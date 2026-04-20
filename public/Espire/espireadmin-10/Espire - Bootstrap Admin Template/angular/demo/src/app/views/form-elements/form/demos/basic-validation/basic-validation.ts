import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({
    selector: 'demo-form-validation',
    templateUrl: './basic-validation.html'
})
export class DemoFormBasicValidationComponent implements OnInit {
    formGroup: FormGroup;

    ages: any[] = [
        { value: '<18', label: 'Under 18' },
        { value: '18', label: '18' },
        { value: '>18', label: 'More than 18' },
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
            ]],
            Check: [false, Validators.requiredTrue],
            Age: [null, Validators.required],
        });
    }

    onSubmit() {
        console.log(this.formGroup);
    }

    onReset() {
        this.formGroup.reset();
    }
}
