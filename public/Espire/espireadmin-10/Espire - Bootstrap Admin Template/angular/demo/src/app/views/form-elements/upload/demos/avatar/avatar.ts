import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { SafeUrl, DomSanitizer } from '@angular/platform-browser'
import { fadeInOut } from '@app/shared/animations/fadeInOut.animation';

@Component({
    selector: 'demo-upload-avatar',
    templateUrl: 'avatar.html',
    animations: [fadeInOut]
})

export class DemoUploadAvatarComponent implements OnInit {

    imageUrl: SafeUrl
    message: string = ''
    showMessage: boolean = false
    status: 'success' | 'fail' | '' = ''

    constructor(private cdr: ChangeDetectorRef, private sanitizer: DomSanitizer) { }

    ngOnInit() { }

    successHandle(file: any): void {
        this.imageUrl = this.sanitizer.bypassSecurityTrustUrl(URL.createObjectURL(file.commonFile.raw))
        this.showMessage = true
        this.status = 'success'
        this.message = 'File uploaded successfully'
        this.dismissMessage()
    }
    
    errorHandle(err: any): void {
        this.showMessage = true
        this.status = 'fail'
        this.message = `File upload failed: ${err}`
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