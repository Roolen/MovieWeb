const mail = new Vue({
    el: '#mail-app',
    data: {
        senders: [],
        messages: [],
        isMessages: false,
        activeUser: "",
        textMessage: "",
        urlSenders: baseUrl + "/mail/senders",
        urlMessages: baseUrl + "/mail/messages",
        urlSendMessage: baseUrl + "/mail/sendMessage"
    },
    mounted: () => { setTimeout(() => { mail.getSenders() }, 100) },
    methods: {
        getSenders: async () => {
            const response = await fetch(mail.urlSenders)

            const body = await response.json()
            console.log(body)

            if (!body.isEmpty) {
                mail.senders = body
            }
        },
        getMessages: async (user) => {
            const response = await fetch(mail.urlMessages, {
                method: "POST",
                body: JSON.stringify({
                    userNick: user
                })
            })

            const body = await response.json()
            console.log(body)

            if (!body.isEmpty) {
                mail.messages = body
                mail.activeUser = user
                mail.isMessages = true

                setTimeout(() => {
                    let block = document.getElementById('messagesBlock')
                    block.scrollTo(0, block.offsetHeight)
                }, 10)
            }
        },
        sendMessage: async () => {
            const response = await fetch(mail.urlSendMessage, {
                method: "POST",
                body: JSON.stringify({
                    nick: mail.activeUser,
                    text: mail.textMessage
                })
            })

            const body = await response.json()
            console.log(body)

            if (body.success) {
                mail.getMessages(mail.activeUser)
                mail.textMessage = ""
            }
        },
        nickSender: (isUser) => {
            if (isUser) {
                return userNick
            }
            else {
                return mail.activeUser
            }
        }
    }
})