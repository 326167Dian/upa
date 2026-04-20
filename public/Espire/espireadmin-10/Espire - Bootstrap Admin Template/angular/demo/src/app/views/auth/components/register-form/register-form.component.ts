import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from "@angular/forms";

@Component({
    selector: 'register-form',
    templateUrl: './register-form.component.html'
})
export class RegisterFormComponent implements OnInit {
    formGroup: FormGroup;

    constructor(private formBuilder: FormBuilder) {}

    ngOnInit() {
        this.formGroup = this.formBuilder.group({
            username: [null, [Validators.required]],
            email: [null, [Validators.required, Validators.email]],
            password: [null, [Validators.required]],
            confirmPassword: [null, [Validators.required, this.confirmationValidator]]
        });
    }

    register() {
        console.log(this.formGroup);
    }

    confirmationValidator = (control: FormControl): { [s: string]: boolean } => {
        if (!control.value) {
            return { required: true };
        } else if (control.value !== this.formGroup.controls.password.value) {
            return { confirm: true, error: true };
        }
        return {};
    };
}
