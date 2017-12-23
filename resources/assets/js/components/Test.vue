<template>
    <div class="panel panel-default">

        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Миний тестүүд</h4>
                </div>
                <div class="col-lg-6">
                    <add-test :test="test" v-on:added="getTests"></add-test>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Тестийн нэр</th>
                    <th>Асуултын тоо</th>
                    <th>Хугацаа (минут)</th>
                    <th>Үүсэгсэн</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="t in tests" :class="test.id && (t.id == test.id) ? 'warning' : ''">
                    <td>{{ t.name }}</td>
                    <td>{{ t.questions.length }}</td>
                    <td>{{ t.minutes }}</td>
                    <td>{{ t.user.name }}</td>
                    <td>
                        <a class="btn btn-default btn-xs" :href="'/test/' + t.id + '/questions'">
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </a>
                        <button class="btn btn-default btn-xs" @click="edit(t)">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button class="btn btn-danger btn-xs" @click="remove(t)">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>

    import AddTest from './AddTest.vue';

    export default {

        data() {

            return {
                test: {
                    name: null,
                    minutes: null
                },
                tests: [],
            }

        },

        components: {
            AddTest
        },

        created() {

            this.getTests();

        },

        methods: {

            getTests() {
                this.test = {
                    name: null,
                    minutes: null
                };
                axios.get('/api/tests').then(response => {
                    this.tests = response.data
                });
            },

            edit(test) {
                this.test = test;
            },

            remove(test) {
                if(confirm('Устгах гэж байна! Та итлгэлтэй байна уу?'))
                {
                    axios.delete('/api/tests/' + test.id + '/destroy').then(response => {
                        this.getTests();
                    }).catch(e => {
                        alert('Устгах боломжгүй')
                    })
                }
            }

        }

    }

</script>