const write = new Vue({
    el: "#write-app",
    data: {
        title: title,
        text: text,
        tags: tags,
        image: "",
        messagePublish: "",
        messageStyle: "",
        urlCreate: baseUrl + "/write/createPost",
        urlChange: baseUrl + "/write/change",
        urlImage: baseUrl + "/write/loadImage",
        urlDelete: baseUrl + "/write/delete"
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

                if (write.image) {
                    let res = await fetch(write.urlImage+"/"+write.title, {
                        method: "POST",
                        body: write.image
                    })

                    const imageBody = await res.json()
                    console.log(imageBody)
                }
                
    
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
        },
        changePost: async () => {
            try {
                const response = await fetch(write.urlChange, {
                    method: "POST",
                    body: JSON.stringify({
                        title: write.title,
                        text: write.text,
                        tags: write.tags
                    })
                })

                if (write.image) {
                    let res = await fetch(write.urlImage+"/"+write.title, {
                        method: "POST",
                        body: write.image
                    })

                    const imageBody = await res.json()
                    console.log(imageBody)
                }

                const body = await response.json()
                console.log(body)

                if (body.success) {
                    write.messagePublish = "Статья изменена"
                    write.messageStyle = "color: green;"
                }
                else {
                    write.messagePublish = "Ошибка"
                }
            } catch (e) {
                console.log(e)
            }
        },
        deletePost: async () => {
            try {
                const isConfirm = confirm("Вы действительно хотите удалить пост?")

                if (!isConfirm) { return }

                const response = await fetch(write.urlDelete+'/'+write.title)

                const body = await response.json()
                console.log(body)

                if (body.success) {
                    write.messagePublish = "Пост удалён"
                    write.messageStyle = "color: green;"

                    setTimeout(() => {
                        window.location.href = baseUrl + "/news"
                    }, 2000)
                }
            } catch (e) {
                console.log(e)
            }
        }
    }
})