import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-form-horizontal',
    templateUrl: './horizontal.html',
    styles: [`
        form {
            max-width: 600px;
        }
    `]
})
export class DemoFormHorizontalComponent implements OnInit {

    radio: string = 'option1';

    constructor() { }

    ngOnInit(): void { }
}
