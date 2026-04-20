import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
    {
        path: 'mail',
        loadChildren: () => import('./mail/mail.module').then(m => m.MailModule),
        data: {
            title: 'Mail',
            hidePageHeader: true
        }
    },
    {
        path: 'chat',
        loadChildren: () => import('./chat/chat.module').then(m => m.ChatModule),
        data: {
            title: 'Chat',
            hidePageHeader: true
        }
    },
    {
        path: 'calendar',
        loadChildren: () => import('./calendar/calendar.module').then(m => m.CalendarAppModule),
        data: {
            title: 'Calendar',
            hidePageHeader: true
        }
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class AppsRoutingModule { }
