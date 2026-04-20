import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'mail-compose',
    templateUrl: './mail-compose.component.html',
    host: {
        '[class.mail-compose]': 'true'
    }
})
export class MailComposeComponent implements OnInit {
    constructor() { }

    ngOnInit(): void { }

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
}
