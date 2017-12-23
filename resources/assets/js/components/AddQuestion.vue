<template>
    <div class="panel panel-default">

        <div class="panel-heading">
            <input type="text" class="form-control" placeholder="Асуулт..." v-model="question.question" />
        </div>

        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item" v-for="(answer, index) in question.answers">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="answer.answer" placeholder="Хариулт..." />
                        <span class="input-group-addon">
                            <input type="checkbox" v-model="answer.is_correct">
                        </span>
                        <span class="input-group-addon" v-if="index > 1">
                            <button class="btn btn-danger btn-xs" @click="removeAnswer(index)">
                                <span class="glyphicon glyphicon-remove-circle"></span>
                            </button>
                        </span>
                    </div>
                </li>
            </ul>
            <button class="btn btn-xs btn-warning pull-right" @click="add">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        <div class="panel-footer">
            <button class="btn btn-sm btn-success" @click="storeQuestion">Хадгалах</button>
        </div>
    </div>
</template>

<script>

    export default {

        props: ['question', 'id'],

        methods: {
            add() {
                this.question.answers.push({
                    answer: null,
                    is_correct: false
                });
            },
            removeAnswer(index) {
                this.question.answers.splice(index, 1);
            },
            storeQuestion() {
                axios.post('/api/test/' + this.id + '/questions/store', this.question).then(response => {
                    this.$emit('added');
                });
            }
        }

    }

</script>