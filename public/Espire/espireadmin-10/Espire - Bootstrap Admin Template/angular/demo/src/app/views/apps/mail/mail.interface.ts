interface Attacthment {
    file: string
    size: string
    type: 'doc' | 'xls' | 'jpg' | 'pdf' | 'pdf'
}

export interface Mail {
    id: number | string
    name: string
    label: string
    marked: number
    avatar: string
    title: string
    date: Date
    mail: string
    content: string
    checked : boolean
    sent: number
    inbox: number
    deleted: number
    draft: number
    attachment: Attacthment[]
}