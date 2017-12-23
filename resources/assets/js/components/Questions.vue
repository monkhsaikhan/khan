<template>

    <div class="row" v-if="test">

        <div class="col-lg-4">
            <add-question :question="question" :id="id" v-on:added="added"></add-question>
        </div>

        <div class="col-lg-8">
            <questions-list :questions="test.questions" v-on:destroyed="destroyed" v-on:edit="edit"></questions-list>
        </div>

    </div>

</template>

<script>

    import AddQuestion from './AddQuestion.vue';
    import QuestionsList from './QuestionsList.vue';

    export default {

        props: ['id'],

        data() {
            return {
                test: null,
                question: {
                    question: null,
                    show: false,
                    answers: [
                        {
                            answer: null,
                            is_correct: false
                        },
                        {
                            answer: null,
                            is_correct: false
                        }
                    ]
                }
            }
        },

        components: {
            AddQuestion,
            QuestionsList
        },

        created() {
            this.getTest();
        },

        methods: {
            getTest() {
                axios.get('/api/test/' + this.id).then(response => {
                    this.test = response.data;
                })
            },
            edit(question) {
                this.question = question;
            },
            destroyed(index) {
                this.test.questions.splice(index, 1);
            },
            added() {
                this.question = {
                    question: null,
                    answers: [
                        {
                            answer: null,
                            is_correct: false
                        },
                        {
                            answer: null,
                            is_correct: false
                        }
                    ]
                };
                this.getTest();
            }
        }

    }

</script>