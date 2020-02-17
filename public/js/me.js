const me = new Vue({
    el: "#me-app",
    data: {
        posts: [],
        countPosts: 0,
        urlPosts: baseUrl + "/Post/posts/" + user,
        urlChangeDesc: baseUrl + "/me/changeDescription",
        urlSubscribe: baseUrl + "/me/subscribe/" + user,
        urlCheckSub: baseUrl + "/me/checkSubscribe/" + user,
        urlCountSubs: baseUrl + "/me/countSubscribers/" + user,
        isEditDesc: false,
        description: description,
        isSubscribe: false,
        countSubs: 0
    },
    mounted: () => {
        setTimeout(() => { me.getPosts()
                           me.checkSubscribe()
                           me.getCountSubs() }, 100) 
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
                let date = new Date(post.date_publish);
                post.date_publish = `${date.getMonth()}.${date.getDate()}\n${date.getFullYear()}`
            }
            me.posts = body;
            me.countPosts = me.posts.length
        },
        getCountSubs: async () => {
            try {
                const response = await fetch(me.urlCountSubs)

                const body = await response.json()

                me.countSubs = body.countSubs
            }
            catch (e) {
                console.log(e)
            }
        },
        changeDesc: async () => {
            try {
                const response = await fetch(me.urlChangeDesc, {
                    method: "POST",
                    body: JSON.stringify({
                        newDesc: me.description
                    })
                })

                const body = await response.json()

                if (!body.isAuth) {
                    console.log("Failed to change description, you don't authorizition")
                }

                if (body.success) {
                    me.isEditDesc = false;
                }
            }
            catch (e) {
                console.log(e)
            }
        },
        checkSubscribe: async () => {
            try {
                const response = await fetch(me.urlCheckSub)

                const body = await response.json()

                if (body.isSubscribe) {
                    me.isSubscribe = true;
                }
            }
            catch (e) {
                console.log(e)
            }
        },
        subscribe: async () => {
            try {
                const response = await fetch(me.urlSubscribe)

                const body = await response.json()

                if (body.isSubscribe) {
                    me.isSubscribe = true
                    me.getCountSubs()
                }
            }
            catch (e) {
                console.log(e)
            }
        }
    }
})