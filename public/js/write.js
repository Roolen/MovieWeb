const write = new Vue({
    el: "#write-app",
    data: {
        title: "",
        text: "",
        tags: "",
        messagePublish: "",
        urlCreate: baseUrl + "/write/createPost"
    },
    methods: {
        createPost: async () => {
            try {
                const response = await fetch(write.urlCreate, {
                    method: "POST",
                    body: JSON.stringify({
                        title: write.title,
                        text: write.text,
                        tags: write.tags
                    })
                })
    
                write.messagePublish = ""
                const body = await response.json()
    
                console.log(body)
    
                if (body.success) {
                    write.messagePublish = "Статья опубликована"
                }
                else {
                    write.messagePublish = "Некоректные данные"
                }  
            }
            catch (e) {
                console.log(e)
            }
        }
    }
})