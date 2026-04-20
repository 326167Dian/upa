import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-upload-list',
    templateUrl: 'list.html',
})

export class DemoUploadListComponent implements OnInit {

    message: string = ''
    showMessage: boolean = false
    status: 'success' | 'fail' | '' = ''
    fileList: any[] = []

    constructor() { }

    ngOnInit() { 

        this.fileList =  [
            {
                name: 'food.jpeg',
                raw: {
                    type: 'image/jpeg'
                },
                url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?' +
                'imageMogr2/thumbnail/360x360/format/webp/quality/100'
            },
            {
                name: 'food2.jpeg',
                raw: {
                    type: 'image/jpeg'
                }, 
                url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99b' +
                'ce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'
            }
        ]
    }

    
}