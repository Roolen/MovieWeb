const search = new Vue({
    el: '#search-app',
    data: {
        posts: [],
        users: [],
        textSearch: "",
        typeSearch: "0",
        isFind: true,
        urlSearch: baseUrl + "/search/search",
        urlSearchUsers: baseUrl + "/search/searchUsers",
        isLoad: false
    },
    methods: {
        search: () => {
            search.posts = []
            search.users = []

            switch (search.typeSearch) {
                case '0':
                    search.searchPosts()
                    break
                case '1':
                    search.searchUsers()
                    break
                case '2':
                    search.searchPosts(true)
                    break
            }
        },
        searchPosts: async (byText = false) => {
            search.isLoad = true

            const url = (byText)
                        ? search.urlSearch + "/true"
                        : search.urlSearch

            const response = await fetch(url, {
                method: "POST",
                body: JSON.stringify({
                    searchLine: search.textSearch
                })
            })

            const body = await response.json()
            console.log(body)
            
            if (body.isEmpty) {
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
        },
        searchUsers: async () => {
            search.isLoad = true

            const response = await fetch(search.urlSearchUsers, {
                method: "POST",
                body: JSON.stringify({
                    searchLine: search.textSearch
                })
            })

            const body = await response.json()
            console.log(body)

            if (!body.isEmpty) {
                search.users = body
                search.isFind = true
                search.isLoad = false
            }
            else {
                search.isFind = false
                search.isLoad = false
            }
        }
    }
})