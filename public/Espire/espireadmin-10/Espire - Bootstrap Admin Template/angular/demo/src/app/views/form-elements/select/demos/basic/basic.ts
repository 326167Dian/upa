import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-select-basic',
    templateUrl: 'basic.html'
})

export class DemoSelectBasicComponent implements OnInit {

    people = [
        {
            id: '5a15b13c36e7a7f00cf0d7cb',
            name: 'Karyn Wright',
        },
        {
            id: '5a15b13c2340978ec3d2c0ea',
            name: 'Rochelle Estes',
            disabled: true
        },
        {
            id: '5a15b13c663ea0af9ad0dae8',
            name: 'Mendoza Ruiz',
        },
        {
            id: '5a15b13cc9eeb36511d65acf',
            name: 'Rosales Russel'
        },
        {
            id: '5a15b13c728cd3f43cc0fe8a',
            name: 'Marquez Nolan',
            disabled: true
        }
    ]

    selectedPersonId = '5a15b13c36e7a7f00cf0d7cb';

    constructor() { }

    ngOnInit() { }
}
