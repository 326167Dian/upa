import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { ChatService } from './chat.service'
import { Chat } from './chat.interface'
import { WildcardSearch } from '@app/shared/utils/WildcardSearch';
import { NumberFormatStyle } from '@angular/common';

@Component({
    selector: 'chat',
    templateUrl: './chat.component.html'
})
export class ChatComponent implements OnInit {

    temp: Chat[]
    chatList: Chat[]
    selectedId: string | NumberFormatStyle
    mobilePanelOpen: boolean
    
    constructor(private chatSvc: ChatService, private cdr: ChangeDetectorRef) {
        this.fetch()
    }

    ngOnInit(): void { }

    fetch(id = '1') {
        this.chatSvc.getChatList().subscribe(res => {
            this.chatList = res
            this.temp = res
            this.chatList.forEach(elm => {
                if(elm.id === id) {
                    this.selectedId = elm.id
                }
            });
            this.cdr.detectChanges()
        })
    }

    selectChat(id: string) {
        this.selectedId = id
        this.mobilePanelOpen = false
    }

    updateChat(id) {
        this.fetch(id)
    }

    serach(e) {
        const searchValue = e.target.value
        if(searchValue) {
            this.chatList = WildcardSearch(this.temp, searchValue)
        } else {
           this.chatList = this.temp
        }
    }

    onMobilePanelToggleOpen() {
        this.mobilePanelOpen = true
    }
}
