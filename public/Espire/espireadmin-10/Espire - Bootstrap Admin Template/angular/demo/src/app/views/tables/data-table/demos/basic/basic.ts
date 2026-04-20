import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-data-table-basic',
    templateUrl: './basic.html'
})
export class DemoDataTableBasicComponent implements OnInit {

    rows = [
        { name: 'Austin', gender: 'Male', company: 'Swimlane' },
        { name: 'Dany', gender: 'Male', company: 'KFC' },
        { name: 'Molly', gender: 'Female', company: 'Burger King' }
    ];
    columns = [{ prop: 'name' }, { name: 'Gender' }, { name: 'Company' }];

    constructor() { }

    ngOnInit(): void { }
}
