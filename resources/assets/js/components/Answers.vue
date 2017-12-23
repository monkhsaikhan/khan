<template>

    <div>
        <div class="row">
            <div class="container">                
                <div class="col-lg-12 text-center">
                    <div class="pull-left">
                        <button class="btn btn-default" @click="prev">
                            <span class="glyphicon glyphicon-chevron-left" ></span>
                        </button>
                    </div>
                    <button class="btn btn-success" @click="endExam">
                        Шалгалт дуусгах
                    </button>
                    <div class="pull-right">
                        <button class="btn btn-default" @click="next">
                            <span class="glyphicon glyphicon-chevron-right" ></span>
                        </button>
                    </div>
                </div>                
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="container">

                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-2">
                    <div class="panel panel-default" v-for="(question, index) in current">

                        <div class="panel-heading">
                            {{ question.question }}
                        </div>

                        <div class="panel-body">

                            <ul class="list-group">
                                <li class="list-group-item" v-for="answer in question.answers_for_guest">
                                    <input type="radio" :name="'answer' + index" :value="answer.id" v-model="question.checked" />
                                    {{ answer.answer }}
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>                

            </div>
        </div>

        <hr />

        <div class="row">
            <div class="container">
                <div class="col-lg-12 text-center">
                    <div class="pull-left">
                        <button class="btn btn-default" @click="prev">
                            <span class="glyphicon glyphicon-chevron-left" ></span>
                        </button>
                    </div>
                    <button class="btn btn-success" @click="endExam">
                        Шалгалт дуусгах
                    </button>
                    <div class="pull-right">
                        <button class="btn btn-default" @click="next">
                            <span class="glyphicon glyphicon-chevron-right" ></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        props: ['questions', 'id'],


        data() {
            let paginated = _.chunk(this.questions, 2);

            return {
                checked: null,
                start_index: 0,
                page: 0,
                paginated,                
                total: paginated.length
            }
        },

        computed: {
            current() {
                return this.paginated[this.page];
            }
        },

        methods: {
            next() {
                if (this.total-1 > this.page) {
                    this.page++;
                }
            },
            prev() {
                if (this.page > 0) {
                    this.page--;
                }        
            },
            endExam() {
                this.$emit('ended', this.paginated);
            }
        }

    }

</script>