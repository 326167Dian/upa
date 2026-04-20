import { NgModule } from '@angular/core';
import { PricingComponent } from'./pricing.component';
import { SharedModule } from '@app/shared/shared.module';
import { routes } from './pricing.routing.module';
import { RouterModule } from '@angular/router';

@NgModule({
    declarations: [ PricingComponent ],
    imports: [ 
        SharedModule,
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [],
})
export class PricingModule {}