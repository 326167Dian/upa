import { Component, OnInit, Output, EventEmitter  } from '@angular/core';
import { FormBuilder, FormGroup, Validators} from "@angular/forms";
import { ToastrService } from 'ngx-toastr';

@Component({
    selector: 'profile-security',
    templateUrl: './security.component.html',
    providers: [ ToastrService ]
})
export class SecurityComponent implements OnInit {
    
    form: FormGroup;
    showEdit: boolean = false;
    saveLogin: boolean = false;
    use2Fa: boolean = false;
    @Output() openMobilePanel = new EventEmitter();

    constructor(private formBuilder: FormBuilder, private toastr: ToastrService) {
        this.form = this.formBuilder.group({
            password: ['', Validators.required],
            newPassword: ['', Validators.required],
            confirmPassword: ['', Validators.required]
        });
    }

    ngOnInit(): void { }


    editForm () {
        this.showEdit = !this.showEdit;
        this.form.reset()
    }

    onSubmit(formData) {
        if (this.form.valid) {
            this.toastr.success('Success!', 'Password successfully changed.');
            this.editForm()
            this.form.reset()
        } 
    }

    onMobilePanelOpen() {
        this.openMobilePanel.emit()
    }
}
