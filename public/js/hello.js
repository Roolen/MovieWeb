var vue = new Vue({
    el: "#hello-app",
    data: {
        firstName: "",
        nickname: "",
        email: "",
        password: "",
        phone: "",
        urlRegister: baseUrl + "/home/registration",
        urlAuthorize: baseUrl + "/home/authorize",
        urlNews: baseUrl + "/news",

        nameWarning: "",
        nickWarning: "",
        emailWarning: "",
        passwordWarning: "",
        phoneWarning: "",
        authWarning: "",

        modal: false
    },
    methods: {
        modalOpen: () => {
            vue.modal = true;
            const main = document.getElementById("main")
            main.style.filter = "blur(10px)"
            main.style.pointerEvents = "none"
            const header = document.getElementById("header")
            header.style.filter = "blur(10px)"
            header.style.pointerEvents = "none"
        },
        modalClose: () => {
            vue.modal = false;
            const main = document.getElementById("main")
            main.style.filter = "blur(0)"
            main.style.pointerEvents = "auto"
            const header = document.getElementById("header")
            header.style.filter = "blur(0)"
            header.style.pointerEvents = "auto"
        },
        registration: async () => {
            const response = await fetch(vue.urlRegister, {
                method: "POST",
                body: JSON.stringify({
                    first_name: vue.firstName,
                    nickname: vue.nickname,
                    email: vue.email,
                    password: vue.password,
                    phone_number: vue.phone
                })
            })
            const body = await response.json()

            console.log(body)

            vue.nameWarning = ""
            vue.nickWarning = ""
            vue.emailWarning = ""
            vue.passwordWarning = ""
            vue.phoneWarning = ""

            // Dublicates checks
            if (body.nickname) {
                vue.nickWarning = "Такой логин уже занят."
            }

            if (body.email) {
                vue.emailWarning = "Такой email уже зарегистрирован."
            }

            if (body.phone) {
                vue.phoneWarning = "Такой номер телефона уже зарегистрирован."
            }

            // Incorrects checks
            if (body.nameIncorrect) {
                vue.nameWarning = "Некорректное имя."
            }

            if (body.nickIncorrect) {
                vue.nickWarning = "Некорректный логин."
            }

            if (body.emailIncorrect) {
                vue.emailWarning = "Некорректный адрес электронной почты."
            }

            if (body.passwordIncorrect) {
                vue.passwordWarning = "Пароль должен быть не менее 6 и не более 24 символов."
            }

            if (body.phoneIncorrect) {
                vue.phoneWarning = "Некорректный номер телефона."
            }

            if (body.success) {
                vue.modalOpen();
            }
        },
        authorize: async () => {
            const response = await fetch(vue.urlAuthorize, {
                method: "POST",
                body: JSON.stringify({
                    nickname: vue.nickname,
                    password: vue.password
                })
            })
            const body = await response.json()

            console.log(body)

            vue.authWarning = ""
            if (body.confirmed) {
                window.location = vue.urlNews
            }
            else if (response.status == '500') {
                vue.authWarning = "Проблемы подключения."
            }
            else {
                vue.authWarning = "Некорректный логин или пароль."
            }
        }
    }
})