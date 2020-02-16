const post = new Vue({
    el: "#post-app",
    data: {
        datePublish: "",
        urlComments: baseUrl + "/post/comments/" + title,
        comments: [],
        countComments: 0
    },
    computed: {
        
    },
    mounted: () => { setTimeout(() => { post.getComments() }, 100) },
    methods: {
        formatDate(dateString) {
            let date = new Date(dateString)
            return `${date.getMonth()}.${date.getDate()}\n${date.getFullYear()}`
        },
        getComments: async () => {
            const response = await fetch(post.urlComments)

            const body = await response.json()

            console.log(body)
        }
    }
})