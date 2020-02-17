const news = new Vue({
    el: "#news-app",
    data: {
        posts: [],
        urlNews: "http://" + window.location.hostname + "/post/getNews"
    },
    mounted: () => {
        setTimeout(() => { news.getPosts() }, 100)
    },
    methods: {
        getPosts: async () => {
            const response = await fetch(news.urlNews)

            const body = await response.json()
            console.log(body)

            for (post of body) {
                if (post.text_post.length > 250) {
                    post.text_post = post.text_post.substring(0, 246)
                    post.text_post += "..."
                }
                let date = new Date(post.date_publish);
                post.date_publish = `${date.getMonth()}.${date.getDate()}\n${date.getFullYear()}`
            }
            news.posts = body;
        }
    }
})