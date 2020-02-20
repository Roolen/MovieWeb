const write = new Vue({
    el: "#write-app",
    data: {
        title: "",
        text: "",
        tags: "",
        image: "",
        messagePublish: "",
        messageStyle: "",
        urlCreate: baseUrl + "/write/createPost",
        urlImage: baseUrl + "/write/loadImage"
    },
    methods: {
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
                write.image = file

                write.messagePublish = "Изображение добавленно"
                write.messageStyle = "color: green;"
            }
            else {
                write.messagePublish = "Неверый формат"
                write.messageStyle = "color: red;"
            }
        },
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

                let res = await fetch(write.urlImage+"/"+write.title, {
                    method: "POST",
                    body: write.image
                })
                const imageBody = await res.json()
    
                console.log(imageBody)
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