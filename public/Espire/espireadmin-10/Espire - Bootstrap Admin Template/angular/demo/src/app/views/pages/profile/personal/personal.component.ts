import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { FormBuilder, FormGroup, Validators} from "@angular/forms";
import { SafeUrl } from '@angular/platform-browser'

@Component({
    selector: 'profile-personal',
    templateUrl: './personal.component.html',
    styles: [`
        ::ng-deep .upload {
            width: 100%
        }
    `]
})

export class PersonalComponent implements OnInit {
    
    formGroup: FormGroup;
    edit: boolean = false; 
    imageUrl: SafeUrl ='/assets/images/avatars/thumb-1.jpg'
    message: string = ''
    showMessage: boolean = false
    status: 'success' | 'fail' | '' = ''
    @Output() openMobilePanel = new EventEmitter();

    constructor(
        private formBuilder: FormBuilder
    ) {
        this.formGroup = this.formBuilder.group({
            firstName: ['', Validators.required],
            lastName: ['', Validators.required],
            email: ['', [
                Validators.required,
                Validators.pattern(/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)
            ]],
            phone: ['', Validators.pattern(/(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\s*[)]?[-\s\.]?[(]?[0-9]{1,3}[)]?([-\s\.]?[0-9]{3})([-\s\.]?[0-9]{3,4})/)],
            website: ['', Validators.pattern(/[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/)],
            gender: ['Male'],
            birthDate: [new Date()],
            address: ['', Validators.required],
            zip: ['', Validators.required],
            bio: ['']
        });
    }
 
    ngOnInit() {
        this.formGroup.reset(
            {
                firstName: 'Julio',
                lastName: 'Baker',
                email: 'juliobaker@themenate.com',
                phone: '12025550193',
                website: '',
                gender: 'Female',
                birthDate: new Date(1993, 6, 7),
                address: '1001 Mary St, Harrisville, WV, 26362',
                zip: '26362',
                bio:'Hello World!'
            }
        )
    }
 
    onSubmit() {
        console.log(this.formGroup);
        this.onEdit()
    }
 
    onReset() {
        this.formGroup.reset();
    }

    onEdit () {
       this.edit = !this.edit
    }

    onMobilePanelOpen() {
        this.openMobilePanel.emit()
    }
}
