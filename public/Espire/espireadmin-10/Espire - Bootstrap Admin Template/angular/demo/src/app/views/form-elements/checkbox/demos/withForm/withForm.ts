import { Component } from '@angular/core';
import {
    FormBuilder,
    FormGroup,
    FormArray,
    FormControl,
    Validators
} from '@angular/forms';

@Component({
    selector: 'demo-checkbox-with-form',
    templateUrl: 'withForm.html'
})

export class DemoCheckboxWithFormComponent {
    form: FormGroup;
    showError = false
    Data: Array<any> = [
        { name: 'Apple', value: 'apple' },
        { name: 'Pear', value: 'pear' },
        { name: 'Orange', value: 'orange' }
    ];

    constructor(private fb: FormBuilder) {
        this.form = this.fb.group({
            checkArray: this.fb.array([], [Validators.required])
        })
    }

    onCheckboxChange(e) {
        const checkArray: FormArray = this.form.get('checkArray') as FormArray;
        if (e.checked) {
            checkArray.push(new FormControl(e.value));
        } else {
            let i: number = 0;
            checkArray.controls.forEach((item: FormControl) => {
                if (item.value == e.value) {
                checkArray.removeAt(i);
                    return;
                }
                i++;
            });
        }
    }

    submitForm() {
        console.log(this.form.controls.checkArray.value)
        if (this.form.controls['checkArray'].errors?.required) {
           this.showError = true
           return 
        }
    }
}