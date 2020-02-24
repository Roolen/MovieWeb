const search = new Vue({
    el: '#search-app',
    data: {
        posts: [],
        textSearch: "",
        isFind: true,
        urlSearch: baseUrl + "/search/search",
        isLoad: false
    },
    methods: {
        searchPosts: async () => {
            search.isLoad = true

            const response = await fetch(search.urlSearch, {
                method: "POST",
                body: JSON.stringify({
                    searchLine: search.textSearch
                })
            })

            const body = await response.json()
            
            if (!body.isEmpty) {
                search.isLoad = false
                search.isFind = false
            }

            for (post of body) {
                if (post.text_post.length > 250) {
                    post.text_post = post.text_post.substring(0, 246)
                    post.text_post += "..."
                }
                let date = new Date(post.date_publish);
                post.date_publish = `${date.getMonth()+1}.${date.getDate()}\n${date.getFullYear()}`
            }

            search.posts = body
            search.posts.reverse()
            search.isFind = true
            search.isLoad = false
        }
    }
})