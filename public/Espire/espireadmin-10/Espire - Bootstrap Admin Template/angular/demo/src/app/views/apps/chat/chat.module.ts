import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { routes } from './chat.routing.module';
import { RouterModule } from '@angular/router';
import { AvatarModule } from '@app/shared/components/avatar/avatar.module';
import { ColumnPanelModule } from '@app/shared/components/column-panel/column-panel.module';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';

import { ChatComponent } from './chat.component';
import { ConversationComponent } from './conversation/conversation.component';

import { ChatService } from './chat.service';

@NgModule({
    declarations: [
        ChatComponent,
        ConversationComponent
    ],
    imports: [ 
        SharedModule,
        ColumnPanelModule,
        AvatarModule,
        PerfectScrollbarModule,
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [
        ChatService
    ],
})
export class ChatModule {}