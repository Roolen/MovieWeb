const post = new Vue({
    el: "#post-app",
    data: {
        datePublish: "",
        urlComments: baseUrl + "/post/comments/" + title,
        urlCreateComment: baseUrl + "/post/createComment",
        comments: [],
        countComments: 0,
        isEditComment: false,
        textComment: ""
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

            if (body.isComments != false) {
                post.comments = body
                post.countComments = body.length
            }
        },
        writeComment: async () => {
            const response = await fetch(post.urlCreateComment, {
                method: "POST",
                body: JSON.stringify({
                    titlePost: title,
                    text: post.textComment
                })
            })

            const body = await response.json()
            console.log(body)

            if (body.isCreate) {
                post.isEditComment = false
                post.textComment = ""
                post.getComments()
            }
        }
    }
})