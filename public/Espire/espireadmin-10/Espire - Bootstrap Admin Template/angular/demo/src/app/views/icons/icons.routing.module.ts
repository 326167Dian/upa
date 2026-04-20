import { IconsComponent } from './icons.component';

export const routes = [
    { 
        path: ':type', 
        component: IconsComponent,
        data: {
            title: 'Icon',
            hidePageHeader: false
        }
    }
];