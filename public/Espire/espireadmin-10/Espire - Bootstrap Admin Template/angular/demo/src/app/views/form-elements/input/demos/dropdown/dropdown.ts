import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-input-dropdown',
    templateUrl: 'dropdown.html'
})

export class DemoInputDropdownComponent implements OnInit {

    dropdownList: string[] = ['Action', 'Another Action', 'Something else here']

    leftDropdownValue: string = 'Dropdown'

    onLeftDropdownChange(val: string) {
        this.leftDropdownValue = val
    }

    constructor() { }

    ngOnInit() { }
}