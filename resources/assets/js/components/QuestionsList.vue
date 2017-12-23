<template>

    <div class="col-md-12">
        <div class="panel panel-default" v-for="(question, index) in questions">

            <div class="panel-heading">
                {{ question.question }}
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-default" @click="show(question)">
                            <span :class="question.show ? 'glyphicon glyphicon-chevron-down' : 'glyphicon glyphicon-chevron-right'"></span>
                        </button>
                        <button type="button" class="btn btn-xs btn-default" @click="edit(question)">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" @click="remove(question, index)">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-body" v-if="question.show">

                <ul class="list-group">
                    <li class="list-group-item" v-for="answer in question.answers">
                        {{ answer.answer }}
                        <div class="badge" v-if="answer.is_correct">
                            Зөв хариулт
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>

</template>

<script>

    export default {

        props: ['questions'],

        methods: {
            show(question)
            {
                question.show = question.show == true ? false : true;
            },
            edit(question) {
                this.$emit('edit', question);
            },
            remove(question, index) {
                if(confirm('Устгах гэж байна! Та итлгэлтэй байна уу?'))
                {
                    axios.delete('/api/questions/' + question.id + '/destroy').then(response => {
                        this.$emit('destroyed', index);
                    }).catch(e => {
                        alert('Устгах боломжгүй')
                    })
                }
            }
        }

    }

</script>