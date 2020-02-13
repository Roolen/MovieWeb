const me = new Vue ({
    el: "#me-app",
    data: {
        posts: [],
        countPosts: 0,
        urlPosts: baseUrl + "/Post/posts/" + user
    },
    methods: {
        getPosts: async () => {
            const response = await fetch(me.urlPosts)
            
            const body = await response.json()
            console.log(body)

            for (post of body) {
                if (post.text_post.length > 250) {
                    post.text_post = post.text_post.substring(0, 246)
                    post.text_post += "..."
                }
            }
            me.posts = body;
            me.countPosts = me.posts.length
        }
    },
    mounted: () => { setTimeout(() => { me.getPosts() }, 100) }
})