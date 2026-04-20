import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { InvoiceComponent } from './invoice.component';
import { routes } from './invoice.routing.module';
import { RouterModule } from '@angular/router';

import { LogoModule } from '@app/shared/components/logo/logo.module';

@NgModule({
    declarations: [ InvoiceComponent ],
    imports: [ 
        SharedModule,
        LogoModule,
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [],
})
export class InvoiceModule {}