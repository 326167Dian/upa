import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { WildcardSearch } from '@app/shared/utils/WildcardSearch';

type LineAwesome = 'regular' | 'brand'

@Component({
    selector: 'icons',
    templateUrl: './icons.component.html',
    providers: [ ToastrService ],
    styles:[`
        .icon-demo {
            cursor: pointer;
        }
        .icon-demo i {
            font-size: 28px;
        }
        .icon-demo:hover i {
            color: #11a1fd
        }
    `]
})
export class IconsComponent implements OnInit {

    iconType: string;
    searchValue: string;
    lineAwesomeType: LineAwesome
    icons = []
    iconsPrimitive = []

    constructor(
        private cdr: ChangeDetectorRef, 
        private route: ActivatedRoute, 
        private toastr: ToastrService,
        private router: Router
    ) {
        this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    }

    ngOnInit(): void {
        this.iconType = this.route.snapshot.paramMap.get('type')
        if(this.iconType === 'feather') {
            import('./feather.icon').then((module) => {
                this.iconsPrimitive = module.featherIcons
                this.icons = module.featherIcons
                this.cdr.markForCheck();
            });
        }
        if(this.iconType === 'line-awesome') {
            this.fetchLineAwesome('regular')
        }
    }

    fetchLineAwesome(type: LineAwesome) {
        this.lineAwesomeType = type
        if(type === 'regular') {
            import('./line-awesome-regular').then((module) => {
                this.iconsPrimitive = module.lineAwesomeIcons
                this.icons = module.lineAwesomeIcons
                this.cdr.markForCheck();
            });
        }
        if(type === 'brand') {
            import('./line-awesome-brand').then((module) => {
                this.iconsPrimitive = module.lineAwesomeIcons
                this.icons = module.lineAwesomeIcons
                this.cdr.markForCheck();
            });
        }
    }

    copyToClipboard (val: string) {
        const holder = document.createElement('textarea');
        let copyValue: string
        holder.style.position = 'fixed';
        holder.style.left = '0';
        holder.style.top = '0';
        holder.style.opacity = '0';
        if(this.iconType === 'feather') {
            copyValue = `<i class="feather ${val}"></i>`
        }
        if(this.iconType === 'line-awesome' && this.lineAwesomeType === 'regular') {
            copyValue = `<i class="la ${val}"></i>`
        }
        if(this.iconType === 'line-awesome' && this.lineAwesomeType === 'brand') {
            copyValue = `<i class="lab ${val}"></i>`
        }
        holder.value = copyValue;
        document.body.appendChild(holder);
        holder.focus();
        holder.select();
        document.execCommand('copy');
        document.body.removeChild(holder);
        this.toastr.success(val, 'Copied!', {
            easeTime: 100,
            toastClass: 'ngx-toastr mt-3',
            positionClass: 'toast-top-center'
        });
    }

    onTabSelect(e) {
        let type: LineAwesome
        switch (e.heading) {
            case 'Regular':
                type = 'regular'
                break;
            case 'Brand':
                type = 'brand'
                break;
            default:
                break;
        }
        this.fetchLineAwesome(type)
    }

    onSerach(e) {
        const searchValue = e.target.value
        if(searchValue) {
            this.icons = WildcardSearch(this.iconsPrimitive, searchValue)
        } else {
           this.icons = this.iconsPrimitive
        }
    }
}
