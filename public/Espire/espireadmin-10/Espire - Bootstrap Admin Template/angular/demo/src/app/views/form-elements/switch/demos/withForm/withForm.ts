import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder } from '@angular/forms';

@Component({
    selector: 'demo-switch-with-form',
    templateUrl: 'withForm.html'
})

export class DemoSwitchWithFormComponent implements OnInit {
    form: FormGroup
    value = false;

    constructor(private formBuilder: FormBuilder) { }

    ngOnInit() {
        this.form = this.formBuilder.group({
            switch: [false]
        });
    }

    submit() {
        console.log(`Value: ${this.form.controls.switch.value}`);
    }
}