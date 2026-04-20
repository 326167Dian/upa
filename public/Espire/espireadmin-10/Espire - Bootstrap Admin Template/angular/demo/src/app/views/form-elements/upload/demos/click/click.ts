import { Component, OnInit, ChangeDetectorRef  } from '@angular/core';
import { fadeInOut } from '@app/shared/animations/fadeInOut.animation';

@Component({
    selector: 'demo-upload-click',
    templateUrl: 'click.html',
    animations: [fadeInOut],
})

export class DemoUploadClickComponent implements OnInit {

    message: string = ''
    showMessage: boolean = false
    status: 'success' | 'fail' | '' = ''

    constructor(private cdr: ChangeDetectorRef) { }

    ngOnInit() { 
    }

    fileList: any[] = [
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

    limit500(file: File): boolean {
        if (file.size > 500000) {
            alert('File has exceeded 500 kb.')
            return false
        }
        return true
    }
      
    successFeedBack () {
        this.showMessage = true
        this.status = 'success'
        this.message = 'File uploaded successfully'
        this.dismissMessage()
    }

    failFeedBack () {
        this.showMessage = true
        this.status = 'fail'
        this.message = 'File upload failed'
        this.dismissMessage()
    }

    dismissMessage() {
        setTimeout(()=>{
            this.showMessage = false;
            this.status = '';
            this.message = '';
            this.cdr.detectChanges();
       }, 3000);
    }
}
