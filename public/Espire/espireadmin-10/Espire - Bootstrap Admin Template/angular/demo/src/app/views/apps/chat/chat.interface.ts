export interface Message {
    avatar: string
    text: string
    from: string
    time: string
    msgType: string
}

export interface Chat {
    id: number | string
    name: string
    lastActive: string
    avatar: string,
    unreadCount: number,
    msg: Message[]
}