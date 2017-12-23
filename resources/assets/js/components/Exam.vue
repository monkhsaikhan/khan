<template>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                {{ test.name }}
            </div>
            <hr />
            <div class="timer" v-if="days <= '0' &&  hours <= '0' && minutes <= '0' && seconds <= '0'">
                <p style="color:red;">
                    0:0:0
                    <span class="label label-danger pull-right"> Шалгалт дууссан </span>
                </p>
            </div>
            <div class="timer" v-else>
                <p> {{ Math.trunc(hours) }}:{{ Math.trunc(minutes) }}:{{ Math.trunc(seconds) }}
                    <span class="label label-success pull-right">Цаг явж байна</span>
                </p>
            </div>
        </div>
        <div class="panel-body">            

            <div class="row" v-if="days <= '0' &&  hours <= '0' && minutes <= '0' && seconds <= '0'">
                <div class="col-lg-4 col-md-4 text-center">
                    <div style="font-size: 24px">
                        Зөв
                        <div>
                            {{ correct }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 text-center">
                    <div style="font-size: 24px">
                        Буруу
                        <div>
                            {{ fail }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 text-center">
                    <div style="font-size: 24px">
                        Хоосон
                        <div>
                            {{ blank }}
                        </div>
                    </div>
                </div>
            </div>    

            <div v-if="!(days <= '0' &&  hours <= '0' && minutes <= '0' && seconds <= '0')">
                <answers ref="answers" :questions="test.questions" :id="test.id" v-on:ended="examEnded"></answers>
            </div>

        </div>
    </div>

</template>

<script>

    import Answers from './Answers.vue';

    export default {
        props: ['start', 'test'],
        components: {
            Answers
        },        
        watch: {
            'seconds': function() {
                if(this.seconds == 0)
                {
                    if(this.days <= '0' &&  this.hours <= '0' && this.minutes <= '0' && this.seconds <= '0')
                    {                        
                        alert('Шалгалт дууссан');
                        this.sendResult();                                        
                    }
                }
            }
        },
        data() {
            return {
                start_time: this.start,
                answers: null,
                result: null,
                now: 0,
                count: 0,
            }
        },
        methods: {            
            examEnded(results) {                
                this.start_time = new Date();                   
            },
            timer_loop() {
                this.count++
                this.now = Math.trunc(new Date().getTime() / 1000)                
                this.count < 200 && setTimeout(this.timer_loop, 1000)
            },            
            sendResult() {
                let answers = this.$refs.answers.paginated;
                axios.patch('/exam/' + this.test.id + '/sendResult', {_result: answers}).then(response => {
                    this.result = response.data;                                        
                }).catch(errors => {

                });
            }
        },
        mounted() {
            this.timer_loop()
        },
        computed: {

            correct() {
                if(this.result === null) { 
                    return 0; 
                }else {
                    return this.result.filter(r => {
                        return r.is_correct === 1
                    }).length;    
                }
            },

            fail() {
                if(this.result === null) { 
                    return 0; 
                }else {
                    return this.result.filter(r => {
                        return r.is_correct === 0
                    }).length;    
                }
            },

            blank() {
                if(this.result === null) { 
                    return 0; 
                }else {
                    return this.result.filter(r => {
                        return r.is_correct === null
                    }).length;    
                }
            },    

            // Цагийн computed property
            seconds() {
                return (this.modifiedDate - this.now) % 60
            },
            minutes() {
                return ((this.modifiedDate - this.now) / 60) % 60
            },
            hours() {
                return ((this.modifiedDate - this.now) / 60 / 60) % 24
            },
            days() {
                return ((this.modifiedDate - this.now) / 60 / 60 / 24)
            },
            modifiedDate: function () {
                return Math.trunc(Date.parse(this.start_time) / 1000)
            }
        }
    }
</script>