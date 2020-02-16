const post = new Vue({
    el: "#post-app",
    data: {
        datePublish: ""
    },
    computed: {
        
    },
    methods: {
        formatDate(dateString) {
            let date = new Date(dateString)
            return `${date.getMonth()}.${date.getDate()}\n${date.getFullYear()}`
        }
    }
})