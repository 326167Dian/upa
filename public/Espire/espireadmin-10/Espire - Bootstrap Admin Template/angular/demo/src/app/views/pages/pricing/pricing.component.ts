import { Component, OnInit } from '@angular/core';
import { HexToRGB } from '@app/shared/utils/HexToRGB';

@Component({
    selector: 'pricing',
    templateUrl: './pricing.component.html'
})
export class PricingComponent implements OnInit {

    hexToRGB = HexToRGB

    pricingPlan = [
        {
            price: 28,
            plan: 'Basic',
            desc: 'Basic planing suitable for personal use.',
            features: [
                {
                    feat: '200 MB of Spaces',
                    avaiable: true
                },
                {
                    feat: '5 Add on Domains',
                    avaiable: true
                },
                {
                    feat: 'Chat Support',
                    avaiable: true
                },
                {
                    feat: 'Microsoft Office 365',
                    avaiable: false
                },
                {
                    feat: 'Smart Sync',
                    avaiable: false
                },
                {
                    feat: 'Analytic Platform',
                    avaiable: false
                }
            ]
        },
        {
            price: 38,
            plan: 'Standard',
            desc: 'Standard planing suitable for most enterprise level',
            features: [
                {
                    feat: '500 MB of Spaces',
                    avaiable: true
                },
                {
                    feat: '10 Add on Domains',
                    avaiable: true
                },
                {
                    feat: 'Chat Support',
                    avaiable: true
                },
                {
                    feat: 'Microsoft Office 365',
                    avaiable: true
                },
                {
                    feat: 'Smart Sync',
                    avaiable: true
                },
                {
                    feat: 'Analytic Platform',
                    avaiable: false
                }
            ]
        },
        {
            price: 50,
            plan: 'Premium',
            desc: 'Basic planing suitable for large scale business',
            features: [
                {
                    feat: 'Unlimited Spaces',
                    avaiable: true
                },
                {
                    feat: 'Unlimited  Domains',
                    avaiable: true
                },
                {
                    feat: 'Chat Support',
                    avaiable: true
                },
                {
                    feat: 'Microsoft Office 365',
                    avaiable: true
                },
                {
                    feat: 'Smart Sync',
                    avaiable: true
                },
                {
                    feat: 'Analytic Platform',
                    avaiable: true
                }
            ]
        }
    ]

    constructor() { }

    ngOnInit(): void { }
}
