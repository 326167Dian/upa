import { Component, OnInit, Input, ChangeDetectorRef, ViewChild, EventEmitter, Output } from '@angular/core';
import { ChatService } from '../chat.service'
import { Chat } from '../chat.interface'
import { PerfectScrollbarComponent } from 'ngx-perfect-scrollbar';

@Component({
    selector: 'conversation',
    templateUrl: './conversation.component.html',
    host: {
        '[class.conversation]': 'true'
    }
})
export class ConversationComponent implements OnInit {

    @ViewChild('chatPS') chatPS: PerfectScrollbarComponent;
    chat: Chat
    message: string
    private _id: string;
    
    @Input() set chatId(id) {
       this._id = id;
       this.fetchChatDetail(id);
    }
    
    get chatId(): string {
        return this._id;
    }

    @Output() updateChat: EventEmitter<any> = new EventEmitter<any>();
    @Output() openMobilePanel = new EventEmitter();

    constructor(private chatSvc: ChatService, private cdr: ChangeDetectorRef) { }

    ngOnInit(): void {
        
    }

    ngAfterViewChecked() {        
        this.scrollToBottom();        
    } 

    fetchChatDetail(id: string) {
        this.chatSvc.getChatDetail(id).subscribe(res => {
            this.chat = res
            this.chatPS.directiveRef.scrollToBottom()
            this.cdr.detectChanges()
        })
    }

    sendMessage() {
        const newMessage = {
            avatar: '',
            text: this.message,
            from: 'me',
            time: '',
            msgType: 'text'
        }
        if(this.message) {
            this.chat.msg.push(newMessage) 
            this.chatSvc.updateConversation(this.chat.msg, this.chat.id).subscribe()
            this.updateChat.emit(this.chat.id)
        } 
        this.message = ''
    }

    scrollToBottom(): void {
        this.chatPS.directiveRef.scrollToBottom()            
    }

    onMobilePanelOpen() {
        this.openMobilePanel.emit()
    }
}
