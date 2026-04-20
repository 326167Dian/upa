import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { MailService } from './mail.service'
import { Mail } from './mail.interface';

export interface category {
    title: string;
    value: string;
    icon: string
}

interface label {
    title: string;
    value: string;
    color: string
}

export const categoryList = [
    {
        title: 'Inbox',
        value: 'inbox',
        icon: 'icon-inbox'
    },
    {
        title: 'Sent',
        value: 'sent',
        icon: 'icon-send'
    },
    {
        title: 'Marked',
        value: 'marked',
        icon: 'icon-star'
    },
    {
        title: 'Draft',
        value: 'draft',
        icon: 'icon-edit'
    },
    {
        title: 'Deleted',
        value: 'deleted',
        icon: 'icon-trash'
    }
]

@Component({
    selector: 'mail',
    templateUrl: './mail.component.html'
})
export class MailComponent implements OnInit {

    categories : category[] = categoryList
    selectedGroup: string 
    showMailContent = false
    selectedMailId: string
    displayContentMobile: boolean

    labels: label[] = [
        {
            title: 'Work',
            value: 'work',
            color: '#f46363'
        },
        {
            title: 'Task',
            value: 'work',
            color: '#00c569 '
        },
        {
            title: 'Custom',
            value: 'work',
            color: '#5a75f9 '
        },
    ]

    mails: Mail[] = []
    compose = false
    showMobilePanel = false

    constructor(private mailSvc: MailService, private cdr: ChangeDetectorRef) {
    }

    ngOnInit(): void { 
        this.getCategory('inbox')
        this.displayContentMobile = false;
    }

    getCategory(value: string) {
        this.showMailContent = false
        this.compose = false
        this.selectedGroup = value
        this.mailSvc.getMail(value).subscribe(res => {
            this.mails = res
            this.selectMailData(this.mails[0].id)
            this.displayContentMobile = false;
            this.cdr.detectChanges()
        });
    }

    selectMailData(id) {
        this.showMailContent = true;
        this.displayContentMobile = true;
        this.selectedMailId = id;
    }

    composeMail() {
        this.compose = true
    }

    onToggleClick() {
        this.showMobilePanel = !this.showMobilePanel
    }

    onMobileContentToggleClick() {
        this.displayContentMobile = false;
    }
}
