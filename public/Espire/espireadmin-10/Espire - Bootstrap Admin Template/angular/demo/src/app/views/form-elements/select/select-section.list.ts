import { DemoSelectBasicComponent } from './demos/basic/basic';
import { DemoSelectOptionsComponent } from './demos/options/options';
import { DemoSelectBindComponent } from './demos/bind/bind';
import { DemoSelectSearchComponent } from './demos/search/search';
import { DemoSelectTagsComponent } from './demos/tags/tags';
import { DemoSelectTemplateComponent } from './demos/template/template';
import { DemoSelectOptionTemplateComponent } from './demos/option-template/option-template';
import { DemoSelectMultiComponent } from './demos/multi/multi';
import { DemoSelectEventComponent } from './demos/event/event';
import { DemoSelectGroupComponent } from './demos/group/group';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Usage',
    anchor: 'usage',
    outlet: DemoTopSectionComponent,
    content: {
      doc: require('!!raw-loader!./docs/usage.md')
    }
  },
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic',
        anchor: 'basic',
        description: `<p>Basic usage of ng-select</p>`,
        component: require('!!raw-loader!./demos/basic/basic'),
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoSelectBasicComponent
      },
      {
        title: 'Display data using ng-option',
        anchor: 'option',
        description: `<p>If you have simple use case, you can omit items array and bind options directly in html using ng-option component.</p>`,
        component: require('!!raw-loader!./demos/options/options'),
        html: require('!!raw-loader!./demos/options/options.html'),
        outlet: DemoSelectOptionsComponent
      },
      {
        title: 'Bind to default values',
        anchor: 'option',
        description: `<p>By default ng-select binds to default label property for display, and keeps whole object as selected value.</p>`,
        component: require('!!raw-loader!./demos/bind/bind'),
        html: require('!!raw-loader!./demos/bind/bind.html'),
        outlet: DemoSelectBindComponent
      },
      {
        title: 'Custom server-side search',
        anchor: 'search',
        description: `<p>Use <b>typeahead</b> to subscribe to search term and load async items.</p><label>Multi select + Typeahead + Custom items (tags)</label>`,
        component: require('!!raw-loader!./demos/search/search'),
        html: require('!!raw-loader!./demos/search/search.html'),
        svc: require('!!raw-loader!./demos/search/data.service'),
        outlet: DemoSelectSearchComponent
      },
      {
        title: 'Custom tags',
        anchor: 'tags',
        description: `<p>By providing custom function to <b>[addTag]</b> you can modify result of new tag</p>`,
        component: require('!!raw-loader!./demos/tags/tags'),
        html: require('!!raw-loader!./demos/tags/tags.html'),
        svc: require('!!raw-loader!./demos/tags/data.service'),
        outlet: DemoSelectTagsComponent
      },
      {
        title: 'Custom label template',
        anchor: 'template',
        description: `<p>Custom selected item label using <b>ng-label-tmp</b></p>`,
        component: require('!!raw-loader!./demos/template/template'),
        html: require('!!raw-loader!./demos/template/template.html'),
        outlet: DemoSelectTemplateComponent
      },
      {
        title: 'Custom option template',
        anchor: 'option-template',
        description: `<p>Custom dropdown panel option template using <b>ng-option-tmp</b></p>`,
        component: require('!!raw-loader!./demos/option-template/option-template'),
        html: require('!!raw-loader!./demos/option-template/option-template.html'),
        outlet: DemoSelectOptionTemplateComponent
      },
      {
        title: 'Multi select',
        anchor: 'multi-select',
        description: `<p>Select multiple elements</p>`,
        component: require('!!raw-loader!./demos/multi/multi'),
        html: require('!!raw-loader!./demos/multi/multi.html'),
        svc: require('!!raw-loader!./demos/multi/data.service'),
        outlet: DemoSelectMultiComponent
      },
      {
        title: 'Output events',
        anchor: 'output-events',
        description: `<p>All output events</p>`,
        component: require('!!raw-loader!./demos/event/event'),
        html: require('!!raw-loader!./demos/event/event.html'),
        svc: require('!!raw-loader!./demos/event/data.service'),
        outlet: DemoSelectEventComponent
      },
      {
        title: 'Group by item key',
        anchor: 'group',
        description: `<p>You can group by item key providing key name as a string to <b>groupBy</b> input</p>`,
        component: require('!!raw-loader!./demos/group/group'),
        html: require('!!raw-loader!./demos/group/group.html'),
        outlet: DemoSelectGroupComponent
      },
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'SelectComponent',
        anchor: 'select-component',
        outlet: NgApiDocComponent
      }
    ]
  }
];
