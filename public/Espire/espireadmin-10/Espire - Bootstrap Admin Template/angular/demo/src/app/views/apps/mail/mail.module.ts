import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { routes } from './mail.routing.module';
import { RouterModule } from '@angular/router';
import { MailComponent } from './mail.component';
import { AvatarModule } from '@app/shared/components/avatar/avatar.module';
import { DropdownModule } from '@app/shared/components/dropdown/dropdown.module';
import { ColumnPanelModule } from '@app/shared/components/column-panel/column-panel.module';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { RatingModule } from 'ngx-bootstrap/rating';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';
import { QuillModule } from 'ngx-quill';

import { MailListComponent } from './mail-list/mail-list.component';
import { MailComponentComponent } from './mail-content/mail-content.component';
import { MailComposeComponent } from './mail-compose/mail-compose.component';

import { MailService } from './mail.service'

@NgModule({
    declarations: [
        MailComponent,
        MailListComponent,
        MailComponentComponent,
        MailComposeComponent
    ],
    imports: [ 
        SharedModule,
        AvatarModule,
        DropdownModule,
        ColumnPanelModule,
        NgxDatatableModule,
        RatingModule,
        PerfectScrollbarModule,
        QuillModule.forRoot(),
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [MailService],
})
export class MailModule {}