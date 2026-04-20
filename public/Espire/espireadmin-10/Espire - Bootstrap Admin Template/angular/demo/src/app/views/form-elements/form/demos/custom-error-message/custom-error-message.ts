import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators} from "@angular/forms";
import { ErrorMessage } from 'ng-bootstrap-form-validation';

@Component({
    selector: 'demo-form-custom-error-message',
    templateUrl: './custom-error-message.html'
})
export class DemoFormCustomErrorMessageComponent implements OnInit {
    formGroup: FormGroup;

    customEmailMessages: ErrorMessage[] = [
        {
            error: 'required',
            format: (label, error) => `${label.toUpperCase()} IS DEFINITELY REQUIRED!`
        }, {
            error: 'pattern',
            format: (label, error) => `${label.toUpperCase()} DOESN'T LOOK RIGHT...`
        }
    ];

    customPasswordMessages: ErrorMessage[] = [
        {
            error: 'required',
            format: (label, error) => `${label.toUpperCase()} IS DEFINITELY REQUIRED!`
        }
    ];

    constructor(private formBuilder: FormBuilder) {}

    ngOnInit() {
        this.formGroup = this.formBuilder.group({
            Email: ['', [
                Validators.required,
                Validators.pattern(/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)
            ]],
            Password: ['', [
                Validators.required,
                Validators.minLength(8),
                Validators.maxLength(20)
            ]]
        });
    }

    onSubmit() {
        console.log(this.formGroup);
    }

    onReset() {
        this.formGroup.reset();
    }
}
