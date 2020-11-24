<template>
    <loading-card :loading="loading" class="px-6 py-4">
        <div>
            <div class="flex mb-4">
                <h3 class="mr-3 text-base text-80 font-bold">{{ card.name }}</h3>
            </div>
            <p class="flex items-center text-4xl mb-4" v-if="errors === null">
                <span v-if="percentage!==null">{{ percentage.toLocaleString() }}%</span>
                <span v-else>-</span>
            </p>
            <div class="flex items-center" v-if="errors === null">
                <p class="text-80 font-bold" v-show="percentage!==null">
                    <span v-if="count!==null">{{ count.toLocaleString() }}</span>
                    of
                    <span v-if="total!==null">{{ total.toLocaleString() }}</span>
                    {{ card.label }}
                </p>
                <p class="text-80 font-bold mt-4" v-show="percentage===null">
                    No data
                </p>
            </div>
            <ul v-if="errors !== null" class="error">
                <template v-for="key in Object.keys(errors)">
                    <li v-for="(message, index) in errors[key]" :key="`${key}_${index}`">
                        {{ message }}
                    </li>
                </template>
            </ul>
        </div>
    </loading-card>
</template>

<script>

export default {
    props: {
        card: {
            type: Object,
            required: true,
        },
    },

    data: () => ({
        loading: true,
        errors: null,
        count: null,
        total: null,
        percentage: null,
    }),

    mounted() {
        this.fetch();
    },
    methods: {
        fetch() {
            this.loading = true;

            Nova.request()
                .get('/nova-vendor/nova-percentage-card/endpoint', this.payload())
                .then(response => {
                    this.loading = false;
                    this.count = response.data.count;
                    this.total = response.data.total;
                    this.percentage = response.data.percentage;
                })
                .catch(({response}) => {
                    this.loading = false;
                    this.errors = response.data.errors;
                })
        },
        payload() {
            return {
                params: {
                    cardClass: this.card.cardClass,
                    cacheKey: this.card.cacheKey,
                    ttl: this.card.ttl,
                }
            };
        },
    },
}
</script>
