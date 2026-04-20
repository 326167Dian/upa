import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Chat, Message } from './chat.interface'

@Injectable({
    providedIn: 'root'
})
export class ChatService {
    apiUrl = `/api/chat`;
 
    constructor(private http: HttpClient) {}

    getChatList() {
        return this.http.get<Array<Chat>>(this.apiUrl)
    }

    getChatDetail(id: string) {
        return this.http.get<Chat>(`${this.apiUrl}/${id}`)
    }

    updateConversation(msg: Message[], id: string | number) {
        let params = {
            id: id,
            msg: msg,
        }
        return this.http.post(`${this.apiUrl}/conversation`, params)
    }
}