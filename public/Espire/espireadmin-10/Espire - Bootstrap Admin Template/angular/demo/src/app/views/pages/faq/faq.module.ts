import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { FaqComponent } from'./faq.component';
import { routes } from './faq.routing.module';
import { RouterModule } from '@angular/router';
import { AccordionModule } from 'ngx-bootstrap/accordion';

@NgModule({
    declarations: [ FaqComponent ],
    imports: [ 
        SharedModule,
        AccordionModule,
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [],
})
export class FaqModule {}