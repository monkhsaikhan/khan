<template>
    <div v-if="test">
        <div class="pull-right form-inline">
            <div class="form-group">
                <input type="input" v-model="test.name" placeholder="Тестийн нэр" class="form-control" />
                <div class="help-block" v-if="errorMessages.errors"> {{ errorMessages.errors.name[0] }}</div>
            </div>
            <div class="form-group">
                <input type="input" v-model="test.minutes" placeholder="Хугацаа" class="form-control" />
                <div class="help-block" v-if="errorMessages.errors"> {{ errorMessages.errors.minutes[0] }}</div>
            </div>
            <button type="button" class="btn btn-default" @click="addTest">{{ test.id ? 'Засах' : 'Нэмэх' }}</button>
        </div>        
    </div>
</template>

<script>

    export default {

        props: ['test'],

        data() {
            return {
                errorMessages: [],
            }
        },

        methods: {
            addTest()
            {
                axios.post('/api/test/store', this.test).then(response => {
                    this.errorMessages = [];
                    this.$emit('added');
                }).catch(e => {
                    this.errorMessages = e.response.data;
                });
            }
        }

    }

</script>