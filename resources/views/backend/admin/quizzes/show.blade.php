@extends('layouts.backend')
@section('content')
<style type="text/css">
.tab-content.right-text-tabs{
  width:100% !important;
}
.vue-tabs .nav{
  margin-right:20px;
}
.vue-tabs .nav ul{
  height: 400px;
  overflow: scroll;
}
</style>
<div>
  <div class="row">
    <div class="col-lg-12 margin-tb">
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
      <div class="col-md-12">
        <div class="well">
          <a href="javascript:void(0)" class="btn btn-default" v-on:click="createQuestion()">
            New Question
          </a>
        </div>
        <toast-container></toast-container>
        <div class="panel panel-default">
          <div class="panel-body">
            <vue-tabs direction="vertical" ref="tabs" type="pills"  @tab-change="changeQuestionIndex" v-model="questionIndex">
              <v-tab title="Welcome Screen">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>Welcome Text</label>
                      <textarea v-model="quiz.description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                      <a class="btn btn-default" href="javascript:void(0)"  v-on:click="saveQuiz(quiz)">Save</a>
                      <a class="btn btn-default" href="javascript:void(0)" @click="firstQuestion()">Next</a>
                    </div>
                  </div>
                </div>
              </v-tab>
              <v-tab v-for="(question, qindex) in questions" v-bind:title="'Q#'+(qindex+1)">
              <div class="panel panel-default">
              <div class="panel-body">
              <div class="form-group">
                <label >Question</label>
                <textarea v-model="question.body" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <a class="btn btn-default" href="javascript:void(0)"  v-on:click="addChoiceToQuestion(question)">Add Answer Choice</a>
              </div>

              <div class="form-group" v-for="(choice, cindex) in question.choices">
                <div class="row">
                  <div class="col-md-9">
                    <input v-model="choice.body" placeholder="" class="form-control" /><input type="checkbox"    v-model="choice.is_answer" true-value="yes" false-value="no" />Answer?
                  </div>
                  <div class="col-md-3">
                    <a href="javascript:void(0)" v-on:click="removeChoiceFromQuestion(question, cindex)" class="btn btn-xs btn-danger">
                      <i class="glyphicon glyphicon-trash"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Score</label>
                <input v-model="question.score" class="form-control" />
              </div>
              <div class="form-group">
                <a class="btn btn-default" href="javascript:void(0)" v-on:click="saveQuestion(question)">Save</a>
                <a class="btn btn-default" href="javascript:void(0)" v-show="(qindex > 0)" @click="prevQuestion(qindex)">Prev</a>
                <a class="btn btn-default" href="javascript:void(0)" v-show="(qindex < (questions.length-1))" @click="nextQuestion(qindex)">Next</a>
                <a class="btn btn-danger" href="javascript:void(0)" v-on:click="deleteQuestion(question, qindex)">Remove Question</a>

              </div>
            </div>
            </div>
          </v-tab>
              <v-tab title="Publish Details">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>@{{ quiz.title }} - @{{ quiz.type }}</label>
                      <textarea v-model="quiz.description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                      <a class="btn btn-default" href="javascript:void(0)"  v-on:click="saveQuiz(quiz)">Save</a>
                      <a class="btn btn-default" href="javascript:void(0)" @click="firstQuestion()">Next</a>
                    </div>
                  </div>
                </div>
              </v-tab>

        </vue-tabs>
                    </div>

      </div>
    </div>
  </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="https://unpkg.com/vue-nav-tabs/themes/vue-tabs.css">
<link rel="stylesheet" href="https://unpkg.com/vue-on-toast@1.0.0-alpha.1/dist/vue-on-toast.min.css">

@endsection
@section('js')
<script src="https://unpkg.com/vue-nav-tabs/dist/vue-tabs.js"></script>
<script src="https://unpkg.com/vue-on-toast@latest/dist/vue-on-toast.min.js"></script>
<script src="{{ asset('js/imports.js') }}"  type="module"></script>
<script type="text/javascript">
  $(function(){
    var _QUIZ_ID_ = '{{ $quiz->id }}';
    var questions = [];

    var questionsApp = new Vue({
      el: '#questions-app',
      data: {
        quiz:{!! ($quiz->toJson()) !!},
        questions:{!! ($quiz->questions->toJson()) !!},
        currentQuestion:{},
        questionIndex:0
      },
      created: function () {
        console.log(this.quiz);
        this.setEmptyCurrentQuestion();
        this.getQuestions();
      },
      methods: {

        saveQuiz:function(quiz){
            axios.put('/admin/quizzes/'+quiz.id, { data: quiz })
              .then(function (response) {
                current_question = response.data;
                Vue.prototype.$vueOnToast.pop('success', 'Awesome!', 'Updated Quiz');
              })
              .catch(function (error) {
                // Wu oh! Something went wrong
                console.log(error.message);
                Vue.prototype.$vueOnToast.pop('error', 'Oops', error.message);

              });
        },
        firstQuestion:function(){
          this.changeQuestionIndex(0);
        },
        changeQuestionIndex: function(tabIndex, newTab, oldTab){
          this.questionIndex = tabIndex;
        },

        addChoiceToQuestion: function(question){
          if (typeof(question.choices)==undefined){
            question.choices = [];
          }
          question.choices.push({ body:'', is_answer:'no'});
        },
        removeChoiceFromQuestion: function(question, cindex){
          question.choices.splice(cindex, 1);
        },

        prevQuestion:function(qindex){
          if(qindex <= 0){
            return;
          }
          this.changeQuestionIndex(qindex);
        },

        nextQuestion:function(qindex){
          if(qindex >= (this.questions.length-1)){
            return;
          }
          this.changeQuestionIndex(qindex+2);
        },
        saveQuestion:function(question){
          
          var current_question = question;
          var self = this;
          if(typeof(question.id) == 'undefined'){
            question.quiz_id = _QUIZ_ID_;

            axios.post('/api/questions', { data: question })
              .then(function (response) {
                current_question = response.data;
                Vue.prototype.$vueOnToast.pop('success', 'Awesome!', 'Created Question');

              })
              .catch(function (error) {
                // Wu oh! Something went wrong
                console.log(error.message);
                Vue.prototype.$vueOnToast.pop('error', 'Oops', error.message);
              });

          }else{
            axios.put('/api/questions/'+question.id, { data: question })
              .then(function (response) {
                current_question = response.data;
                Vue.prototype.$vueOnToast.pop('success', 'Awesome!', 'Updated Question');

              })
              .catch(function (error) {
                // Wu oh! Something went wrong
                console.log(error.message);
                Vue.prototype.$vueOnToast.pop('error', 'Oops', error.message);

              });

          }

        },

        removeChoice: function(cindex){
          this.currentQuestion.choices.splice(cindex, 1);
        },
        setEmptyCurrentQuestion: function(){
          this.currentQuestion = { body:'', choices:[{body:'', is_answer:'no'},{body:'', is_answer:'no'}] };
        },
        deleteQuestion:function(question, index){
          if(!confirm('Are you sure you want to delete this question?')){
            return;
          }
          var self = this;
          var current_question = question;
          var qindex = index;
          if(typeof(question.id) == 'undefined'){
            self.questions.splice(qindex, 1);
            self.$refs.tabs.navigateToTab(self.questions.length-1);
            return;
          }
          axios.delete('/api/questions/'+question.id)
            .then(function (response) {
              self.questions.splice(qindex, 1);
              if(self.questions.length > 0){
                self.$refs.tabs.navigateToTab(self.questions.length-1);
              }
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
          var self = this;
          if(typeof(this.currentQuestion.id)=='undefined'){
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
        },
        createQuestion: function(){
          question = { body:'', choices:[{body:'', is_answer:'no'},{body:'', is_answer:'no'}] };
          this.questions.push(question);
          console.log($('.vue-tabs').find('ul li').last());
          $('.vue-tabs').find('ul li').last().find('a').trigger('click')
        },
        

      }
    });
});

</script>
@endsection