@extends('layouts.backend')
@section('content')
<div>
  <div class="row">
    <div class="col-lg-8 margin-tb">
      <h3>{{ '#'.$quiz->id }} - {{ $quiz->title }}</h3>
      <div class="well">
        <small>Description</small><br/>
        {{ $quiz->description }}
      </div>
      <dl>
        <dt>Accessible From:</dt>
        <dd>{{ $quiz->accessible_from }}</dd>
        <dt>Accessible Until:</dt>
        <dd>{{ $quiz->accessible_to }}</dd>
      </dl>
      @if($quiz->isDraft())
        <div class="alert alert-warning">
          QUIZ IS CURRENTLY IN DRAFT MODE <a class="btn btn-info" href="{{ route('admin.quizzes.publish', $quiz) }}">PUBLISH</a>
        </div>
      @else
        <div class="alert alert-info">
          QUIZ IS CURRENTLY PUBLISHED <a class="btn btn-warning" href="{{ route('admin.quizzes.unpublish', $quiz) }}">UNPUBLISH</a>
        </div>
      @endif
    </div>
  </div>
    <div id="questions-app" class="row">
        <div class="col-lg-8">
          <div v-for="(question, qindex) in questions">
            <div class="panel panel-default">
              <div class="panel-heading">
              <span class="pull-right">
                <a href="javascript:void(0)" v-on:click="editQuestion(question)" class="btn btn-xs btn-default">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a> 
                <a href="javascript:void(0)" v-on:click="deleteQuestion(question)" class="btn btn-xs btn-default">
                  <i class="glyphicon glyphicon-trash"></i>
                </a> 
              </span>
<b>@{{ question.body }}</b>
              </div>
              <div class="panel-body">
                <table class="table">
                  <tr v-for="(choice, cindex) in question.choices">
                    <td>
                      @{{ choice.body }}
                    </td>
                    <td class="text-right">
                      <span class="label label-success" v-show="choice.is_answer == 'yes'">CORRECT</span>
                      <span class="label label-danger" v-show="choice.is_answer == 'no'">WRONG</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div style="height:100px;"></div>






        </div>
        <div class="col-md-3 " style="right:0px;bottom:20px;position:fixed; ">
          <div class="panel panel-warning" style="">
            <div class="panel-heading">
              Questionator
            </div>
            <div class="panel-body ">
            <div class="form-group">
              <label >Question</label>
              <textarea v-model="currentQuestion.body" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <a class="btn btn-default" href="javascript:void(0)"  v-on:click="addChoiceToCurrentQuestion()">Add Answer Choice</a>
            </div>

            <div class="form-group" v-for="(choice, cindex) in currentQuestion.choices">
              <div class="row">
                <div class="col-md-9">
                  <input v-model="choice.body" placeholder="" class="form-control" /><input type="checkbox"    v-model="choice.is_answer" true-value="yes" false-value="no" />Answer?
                </div>
                <div class="col-md-3">
                  <a href="javascript:void(0)" v-on:click="removeChoice(cindex)" class="btn btn-xs btn-danger">
                    <i class="glyphicon glyphicon-trash"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <a class="btn btn-default" href="javascript:void(0)" v-on:click="saveCurrentQuestion">Save</a>
            </div>
          </div>
          </div>

        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="https://unpkg.com/vue-nav-tabs/themes/vue-tabs.css">
@endsection
@section('js')
<script src="https://unpkg.com/vue-nav-tabs/dist/vue-tabs.js"></script>
<script type="text/javascript">
  $(function(){
    var _QUIZ_ID_ = '{{ $quiz->id }}';
    var questions = [];
    import VueTabs from 'vue-nav-tabs'
    import 'vue-nav-tabs/themes/vue-tabs.css'
    Vue.use(VueTabs)

    var questionsApp = new Vue({
      el: '#questions-app',
      data: {
        quiz:{},
        questions:{!! ($quiz->questions->toJson()) !!},
        currentQuestion:{}
      },
      created: function () {
        console.log(this.quiz);
        this.setEmptyCurrentQuestion();
        this.getQuestions();
      },
      methods: {
        removeChoice: function(cindex){
          this.currentQuestion.choices.splice(cindex, 1);
        },
        setEmptyCurrentQuestion: function(){
          this.currentQuestion = { body:'', choices:[{body:'', is_answer:'no'},{body:'', is_answer:'no'}] };
        },
        deleteQuestion:function(question){
          if(!confirm('Are you sure you want to delete this question?')){
            return;
          }
          var self = this;
          axios.delete('/api/questions/'+question.id)
            .then(function (response) {
              self.getQuestions();
            })
            .catch(function (error) {
              // Wu oh! Something went wrong
              console.log(error.message);
            });
        },
        editQuestion:function(question){
          this.currentQuestion = question;
        },
        getQuestions: function() {
          var self = this;
          axios.get('/api/questions', {
                        params: {
                          quiz_id:_QUIZ_ID_
                        }
                     })
              .then(function (response) {
                self.questions = response.data;
                console.log(self.questions);
              })
              .catch(function (error) {
                console.log(error.message);
              });
        },
        addChoiceToCurrentQuestion: function(){
          if (typeof(this.currentQuestion.choices)==undefined){
            this.currentQuestion.choices = [];
          }
          this.currentQuestion.choices.push({ body:'', is_answer:'no'});
          console.log(this.currentQuestion.choices);
        },
        saveCurrentQuestion: function(){
          console.log(typeof(this.currentQuestion.id));
          var self = this;
          if(typeof(this.currentQuestion.id) == 'undefined'){
            this.currentQuestion.quiz_id = _QUIZ_ID_;

            axios.post('/api/questions', { data: this.currentQuestion })
              .then(function (response) {
                  self.getQuestions();
              })
              .catch(function (error) {
                // Wu oh! Something went wrong
                console.log(error.message);
              });

          }else{
            axios.put('/api/questions/'+this.currentQuestion.id, { data: this.currentQuestion })
              .then(function (response) {
                self.getQuestions();
              })
              .catch(function (error) {
                // Wu oh! Something went wrong
                console.log(error.message);
              });

          }

          this.setEmptyCurrentQuestion();
        },
        createQuestion: function(question){
        },
        

      }
    });
});

</script>
@endsection