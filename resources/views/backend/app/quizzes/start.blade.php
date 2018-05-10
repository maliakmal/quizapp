@extends('layouts.student')
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
<div class="container">
<div  id="questions-app">
  <div v-if="status=='started'">
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <div class="card-body">
            Question @{{ (questionIndex+1) }} / @{{ (questions.length) }}
            <span class="pull-right">@{{ timerDisplay }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 ">
        <toast-container></toast-container>

        <div class="card">
          <div class="card-body">
            <div v-for="(question, qindex) in questions" v-if="qindex==questionIndex">
              <div class="lead">@{{ question.body }}</div><br/><br/>
              <ul class="list-unstyled">
                <li v-for="(choice, cindex) in question.choices">
                  <input type="radio" v-bind:value="cindex" v-model="question.selectedAnswer" />
                  @{{ choice.body }}
                </li>
              </ul>

              <a class="btn btn-light" href="javascript:void(0)" v-show="(qindex > 0)" @click="prevQuestion(qindex)">Prev</a>
              <a class="btn btn-light" href="javascript:void(0)" v-show="(qindex < (questions.length-1))" @click="nextQuestion(qindex)">Next</a>
              <a class="btn btn-primary" href="javascript:void(0)"  v-show="(qindex == (questions.length-1))" v-on:click="submitQuiz()">Submit</a>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="status=='submitted'">
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <p>&nbsp;</p>
              <h3>Test submitted - loading results</h3>
              <p>&nbsp;</p>
              <img src="{{ asset('images/preloader.svg') }}" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="status=='completed'">
    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <div class="card-body">
            <b>Results:</b>
          </div>
        </div>
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
    var _USER_ = '{{ \Auth::user()->id }}';
    var _STARTAT_ = "{{ date('Y-m-d H:i:s') }}";
    var questions = [];
    var timerObj;
    Vue.config.devtools = true;
    var questionsApp = new Vue({
      el: '#questions-app',
      data: {
        quiz:{!! ($quiz->toJson()) !!},
        questions:{!! ($quiz->questions->toJson()) !!},
        questionIndex:0,
        status:'',
        timer:true,
        timerLength:{{ $quiz->duration }},
        timerTotal:{{ $quiz->duration }},
        timerWidth:100,
        timerDisplay:''
      },
      created: function () {
        console.log(this.quiz);
        for(i in this.questions){
          this.questions[i]['selectedAnswer'] = false;
        }
        this.getQuestions();
        this.status = 'started';
      },
      mounted: function(){
        console.log(this.timer);Vue.config.devtools = true
        if (this.timer == true){
            this.startTimer();
            console.log('timer started');
        } else {
            this.timerWidth = 0;
        }
      },

      methods: {
        getQuestions: function(){

        },
        startTimer:function(){
          timerObj = window.setInterval(this.timerTick, 1000);
          this.timerFormat();
        },

        stopTimer:function(){
          window.clearInterval(timerObj);
          timerObj = null;
        },

        timerTick:function(){
          if (this.timerLength != 0) {
            this.timerLength -= 1;
            this.timerBarWidth();
            this.timerFormat();
          } else {
            Vue.prototype.$vueOnToast.pop('success', 'Times up!', 'Quiz Over!');
            this.submitQuiz();
            // Some broadcast stuff to disable answering
          }
        },

        timerFormat:function(){
            let minutes = Math.floor(this.timerLength / 60);
            let seconds = this.timerLength % 60;

            if (seconds < 10){ seconds = "0"+seconds; }
            if (minutes < 10){ minutes = "0"+minutes; }
            this.timerDisplay = minutes + ":" + seconds;
        },

        timerBarWidth:function(){
          let amount = 100/this.timerseconds;
          this.timerWidth -= amount;
        },

        submitQuiz:function(){
          this.stopTimer();
          this.status = 'submitted';
          var self = this;
          data = {score:0, duration:(this.timerTotal - this.timerLength), total_score:0};
          for(i in this.questions){
            question = this.questions[i];
            choices = question['choices'];
            for(j in choices){
              choice = choices[j];
              if(choice['is_answer'] === 'yes'){
                if(question.selectedAnswer === j){
                  data['score'] += question['score'];
                }
              }
            }
            data['total_score'] += question['score'];
          }
          
          data['quiz'] = _QUIZ_ID_;
          data['user'] = _USER_;
          data['start_at'] = _STARTAT_;
          data['questions'] = this.questions;

          axios.post('/api/submissions', { data: data })
            .then(function (response) {
              Vue.prototype.$vueOnToast.pop('success', 'Awesome!', 'Created Question');
              self.status = 'completed';
              self.quizResults = response.data;
            })
            .catch(function (error) {
              // Wu oh! Something went wrong
              console.log(error.message);
              Vue.prototype.$vueOnToast.pop('error', 'Oops', error.message);
            });

          Vue.prototype.$vueOnToast.pop('success', 'Awesome!', 'Updated Quiz');
        },

        prevQuestion:function(qindex){
          if(qindex <= 0){
            return;
          }
          this.changeQuestionIndex(qindex-1);
        },

        nextQuestion:function(qindex){
          if(qindex >= (this.questions.length-1)){
            return;
          }
          this.changeQuestionIndex(qindex+1);
        },

        changeQuestionIndex: function(tabIndex){
          this.questionIndex = tabIndex;
        },


      }
    });
});

</script>
@endsection