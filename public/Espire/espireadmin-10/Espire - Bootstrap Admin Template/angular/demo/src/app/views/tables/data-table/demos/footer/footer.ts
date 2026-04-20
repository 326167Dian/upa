import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-data-table-footer',
    templateUrl: './footer.html'
})
export class DemoDataTableFooterComponent implements OnInit {
    rows = [
        { name: 'Ethel Price', gender: 'female', company: 'Johnson, Johnson and Partners, LLC CMP DDC' },
        { name: 'Claudine Neal', gender: 'female', company: 'Sealoud' },
        { name: 'Beryl Rice', gender: 'female', company: 'Velity' },
        { name: 'Wilder Gonzales', gender: 'male', company: 'Geekko' },
        { name: 'Georgina Schultz', gender: 'female', company: 'Suretech' }
    ];
    columns = [{ prop: 'name' }, { name: 'Gender' }, { name: 'Company' }];

    constructor() {
    }

    ngOnInit(): void { }
}
