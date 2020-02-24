const me = new Vue({
    el: "#me-app",
    data: {
        posts: [],
        countPosts: 0,
        urlPosts: baseUrl + "/Post/posts/" + user,
        urlChangeDesc: baseUrl + "/me/changeDescription",
        urlSubscribe: baseUrl + "/me/subscribe/" + user,
        urlDescribe: baseUrl + "/me/describe/" + user,
        urlCheckSub: baseUrl + "/me/checkSubscribe/" + user,
        urlCountSubs: baseUrl + "/me/countSubscribers/" + user,
        urlChangeAvatar: baseUrl + "/me/changeImage",
        urlSendMessage: baseUrl + "/mail/sendMessage",
        isAvatar: (isAvatar == 1),
        isEditDesc: false,
        description: description,
        isSubscribe: false,
        countSubs: 0,
        textMessage: "",
        isEditMessage: false,
        isLoad: true
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

            if (body.empty) {
                me.isLoad = false
                return
            }

            for (post of body) {
                if (post.text_post.length > 250) {
                    post.text_post = post.text_post.substring(0, 246)
                    post.text_post += "..."
                }
                let date = new Date(post.date_publish);
                post.date_publish = `${date.getMonth()+1}.${date.getDate()}\n${date.getFullYear()}`
            }
            me.posts = body
            me.posts.reverse()
            me.countPosts = me.posts.length
            me.isLoad = false;
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
        },
        describe: async () => {
            try {
                const response = await fetch(me.urlDescribe)

                const body = await response.json()

                if (body.isDescribe) {
                    me.isSubscribe = false
                    me.getCountSubs()
                }
            }
            catch (e) {
                console.log(e)
            }
        },
        addPost: () => {
            location.href = baseUrl + "/write/index"
        },
        changeImage: async (event) => {
            let formats = ["image/jpg", "image/jpeg", "image/png"]
            let isFormat = false
            let file = event.target.files[0]

            for (format of formats) {
                if (file.type == format) {
                    isFormat = true
                }
            }

            if (isFormat) {
                let res = await fetch(me.urlChangeAvatar, {
                    method: "POST",
                    body: file
                })
                const body = await res.json()

                console.log(body)

                if (body.success) {
                    alert("Аватар изменён")
                    location.href = location.href
                }
                else {
                    alert("Ошибка при изменении аватара")
                }
            }
            else {
                alert("Неверный формат")
            }
            
        },
        sendMessage: async () => {
            const response = await fetch(me.urlSendMessage, {
                method: "POST",
                body: JSON.stringify({
                    nick: user,
                    text: me.textMessage
                })
            })

            const body = await response.json()

            if (body.success) {
                alert("Сообщение успешно отправленно\n" +
                "Перейдите на страницу сообщений, для дальнейшего общения.")

                me.isEditMessage = false;
                me.textMessage = ""
            }
        }
    }
})