import { Component, OnInit, ViewChild,ElementRef } from '@angular/core';
import { SafeUrl, DomSanitizer } from '@angular/platform-browser'
import { ModalDirective } from 'ngx-bootstrap/modal';

@Component({
    selector: 'demo-upload-gallery',
    templateUrl: 'gallery.html'
})

export class DemoUploadGalleryComponent implements OnInit {

    galleryImageUrl: SafeUrl

    @ViewChild('galleryModal', { static: false }) galleryModal: ModalDirective;

    constructor( private sanitizer: DomSanitizer) { }

    ngOnInit() { }

    previewHandle(commonFile: any): void {
        const file: File = commonFile.raw
        this.galleryImageUrl = this.sanitizer.bypassSecurityTrustUrl(URL.createObjectURL(file))
        this.galleryModal.show()
    }

    removeHandle(commonFile: any): void {
        alert('File removed')
    }
}