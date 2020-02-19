const write = new Vue({
    el: "#write-app",
    data: {
        title: "",
        text: "",
        tags: "",
        messagePublish: "",
        messageStyle: "",
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
    
                write.messageStyle = "color: red;"

                if (body.success) {
                    write.messagePublish = "Статья опубликована"
                    write.messageStyle = "color: green;"
                }
                else if (body.isDuplicate) {
                    write.messagePublish = "Такое название уже занято"
                }
                else if (body.isEmpty) {
                    write.messagePublish = "Введите заголовок и текст"
                }
                else {
                    write.messagePublish = "Ошибка сервера"
                }  
            }
            catch (e) {
                console.log(e)
            }
        }
    }
})