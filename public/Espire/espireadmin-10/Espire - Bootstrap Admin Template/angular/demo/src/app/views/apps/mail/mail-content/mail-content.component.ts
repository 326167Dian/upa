import { Component, OnInit, Input, ChangeDetectorRef, Output, EventEmitter } from '@angular/core';
import { Mail } from '../mail.interface';
import { MailService } from '../mail.service'; 

@Component({
    selector: 'mail-content',
    templateUrl: './mail-content.component.html',
    host: {
        '[class.mail-content]': 'true'
    }
})
export class MailComponentComponent implements OnInit {

    private _id: string;

    @Output() onMobileContentClose = new EventEmitter();
    
    @Input() set mailId(id) {
       this._id = id;
       this.getMailDetail(id);
    }
    
    get mailId(): string {
        return this._id;
    }

    mail: Mail
    loading = false
    replyInput = false

    constructor(private mailSvc: MailService, private cdr: ChangeDetectorRef) { }

    ngOnInit(): void { }

    getMailDetail(id: string) {
        this.loading = true
        this.mailSvc.getMailContent(id).subscribe(res => {
            this.mail = res
            this.loading = false
            this.cdr.detectChanges()
        })
    }

    editorConfig = {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],        
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],               
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],  
            [{ 'align': [] }],
            ['link', 'image']                        
        ]
    };

    showInput() {
        this.replyInput = true
    }
    
    hideInput() {
        this.replyInput = false
    }

    onMobileContentToggleClick() {
        this.onMobileContentClose.emit()
    }
}
