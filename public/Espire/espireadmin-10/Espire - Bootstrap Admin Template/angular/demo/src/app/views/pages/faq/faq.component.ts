import { Component, OnInit } from '@angular/core';
import { HexToRGB } from '@app/shared/utils/HexToRGB';

@Component({
    selector: 'faq',
    templateUrl: './faq.component.html'
})
export class FaqComponent implements OnInit {

    selectedCategory: string = 'Navigation';
    hexToRGB = HexToRGB

    category = [
        {
            title: 'Navigation',
            icon: 'las la-compass',
            color: '#11a1fd'
        },
        {
            title: 'Price & Plans',
            icon: 'las la-tag',
            color: '#5a75f9'
        },
        {
            title: 'Affiliate',
            icon: 'las la-user-friends',
            color: '#ff9842'
        },
        {
            title: 'Usage',
            icon: 'las la-book',
            color: '#00c569'
        }
    ]

    faqList = {
        'Navigation': [
            {
                key: "faq-1-1",
                open: false,
                title: "What are the benefits of a navigation system?",
                desc: "So how did the classical Latin become so incoherent? According to McClintock, a 15th century typesetter likely scrambled part of Cicero's De Finibus in order to provide placeholder text to mockup various fonts for a type specimen book. Aldus Corporation, which later merged with Adobe Systems, ushered lorem ipsum into the information age with its desktop publishing software Aldus PageMaker. The program came bundled with lorem ipsum dummy text for laying out page content, and other word processors like Microsoft Word followed suit."
            },
            {
                key: "faq-1-2",
                open: false,
                title: "Systems Accurate",
                desc: "Twitch tail in permanent irritation poop on grasses, drink water out of the faucet, plays league of legends have my breakfast spaghetti yarn. Taco cat backwards spells taco cat stick butt in face."
            },
            {
                key: "faq-1-3",
                open: false,
                title: "How to start?",
                desc: "One brave soul did take a stab at translating the almost-not-quite-Latin. According to The Guardian, Jaspreet Singh Boparai undertook the challenge with the goal of making the text “precisely as incoherent in English as it is in Latin - and to make it incoherent in the same way”. As a result, “the Greek 'eu' in Latin became the French 'bien' [...] and the '-ing' ending in 'lorem ipsum' seemed best rendered by an '-iendum' in English.”"
            },
            {
                key: "faq-1-4",
                open: false,
                title: "Where to find site map?",
                desc: "It's difficult to find examples of lorem ipsum in use before Letraset made it popular as a dummy text in the 1960s, although McClintock says he remembers coming across the lorem ipsum passage in a book of old metal type samples. So far he hasn't relocated where he once saw the passage, but the popularity of Cicero in the 15th century supports the theory that the filler text has been used for centuries."
            },
            {
                key: "faq-1-5",
                open: false,
                title: "How to apply?",
                desc: "Qui animated corpse, cricket bat max brucks terribilem incessu zomby. The voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. Zonbi tattered for solum oculi eorum defunctis go lum cerebro. Nescio brains an Undead zombies. Sicut malus putrid voodoo horror. Nigh tofth eliv ingdead."
            },
            {
                key: "faq-1-6",
                open: false,
                title: "Is it secure?",
                desc: "Qui animated corpse, cricket bat max brucks terribilem incessu zomby. The voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. Zonbi tattered for solum oculi eorum defunctis go lum cerebro. Nescio brains an Undead zombies. Sicut malus putrid voodoo horror. Nigh tofth eliv ingdead."
            }
        ],
        'Price & Plans': [
            {
                key: "faq-2-1",
                open: false,
                title: "Getting Started",
                desc: "Biscuit oat cake marzipan. Danish liquorice ice cream. Marshmallow marzipan liquorice liquorice cookie topping powder tiramisu candy. Wafer pudding soufflé cake sweet roll candy canes caramels icing toffee. Cookie chocolate cake chocolate. Toffee cookie croissant cotton candy croissant. Oat cake gummi bears jelly. Apple pie bear claw jujubes sesame snaps powder. Lollipop bear claw carrot cake. Bonbon bonbon jelly beans cheesecake gummi bears muffin cake bear claw bear claw. "
            },
            {
                key: "faq-2-2",
                open: false,
                title: "Elements",
                desc: "Lemon drops donut jelly-o liquorice chocolate donut. Gummies wafer gummi bears tart ice cream toffee candy canes caramels. Wafer dessert chocolate bar chocolate dragée pastry chupa chups. Bear claw bonbon liquorice powder gingerbread caramels. Topping sugar plum pastry sweet roll apple pie chocolate bar."
            },
            {
                key: "faq-2-3",
                open: false,
                title: "Compentents",
                desc: "Bear claw fruitcake danish soufflé sweet roll. Chocolate chocolate tootsie roll dragée pie ice cream. Jelly beans chupa chups biscuit candy canes marshmallow toffee tootsie roll caramels. Halvah tart carrot cake gummies bonbon halvah candy sweet roll liquorice. Oat cake toffee gummi bears dessert."
            },
            {
                key: "faq-2-4",
                open: false,
                title: "Modules",
                desc: "Bear claw fruitcake danish soufflé sweet roll. Chocolate chocolate tootsie roll dragée pie ice cream. Jelly beans chupa chups biscuit candy canes marshmallow toffee tootsie roll caramels. Halvah tart carrot cake gummies bonbon halvah candy sweet roll liquorice. Oat cake toffee gummi bears dessert."
            },
            {
                key: "faq-2-5",
                open: false,
                title: "Overview",
                desc: "Dessert jujubes tart chocolate cake oat cake cupcake. Wafer macaroon lollipop chocolate sugar plum marshmallow lollipop jelly-o chupa chups. Lemon drops ice cream topping. Toffee pudding sweet cookie sweet chocolate. "
            },
            {
                key: "faq-2-6",
                open: false,
                title: "Versioning",
                desc: "So when is it okay to use lorem ipsum? First, lorem ipsum works well for staging. It's like the props in a furniture store—filler text makes it look like someone is home. The same Wordpress template might eventually be home to a fitness blog, a photography website, or the online journal of a cupcake fanatic. Lorem ipsum helps them imagine what the lived-in website might look like."
            }
        ],
        'Affiliate': [
            {
                key: "faq-3-1",
                open: false,
                title: "How to start?",
                desc: "The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children."
            },
            {
                key: "faq-3-2",
                open: false,
                title: "Is there any discount?",
                desc: "Well, the way they make shows is, they make one show. That show's called a pilot. Then they show that show to the people who make shows, and on the strength of that one show they decide if they're going to make more shows. Some pilots get picked and become television programs. "
            },
            {
                key: "faq-3-3",
                open: false,
                title: "Is it expensive?",
                desc: "Normally, both your asses would be dead as fucking fried chicken, but you happen to pull this shit while I'm in a transitional period so I don't wanna kill you, I wanna help you. But I can't give you this case, it don't belong to me."
            },
            {
                key: "faq-3-4",
                open: false,
                title: "Is it secure?",
                desc: "Twitch tail in permanent irritation poop on grasses, drink water out of the faucet, plays league of legends have my breakfast spaghetti yarn. Taco cat backwards spells taco cat stick butt in face."
            }
        ],
        'Usage': [
            {
                key: "faq-4-1",
                open: false,
                title: "Is there any discount?",
                desc: "Well, the way they make shows is, they make one show. That show's called a pilot. Then they show that show to the people who make shows, and on the strength of that one show they decide if they're going to make more shows. Some pilots get picked and become television programs. "
            },
            {
                key: "faq-4-2",
                open: false,
                title: "Is it secure?",
                desc: "Qui animated corpse, cricket bat max brucks terribilem incessu zomby. The voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. Zonbi tattered for solum oculi eorum defunctis go lum cerebro. Nescio brains an Undead zombies. Sicut malus putrid voodoo horror. Nigh tofth eliv ingdead."
            },
            {
                key: "faq-4-3",
                open: false,
                title: "Where to find site map?",
                desc: "It's difficult to find examples of lorem ipsum in use before Letraset made it popular as a dummy text in the 1960s, although McClintock says he remembers coming across the lorem ipsum passage in a book of old metal type samples. So far he hasn't relocated where he once saw the passage, but the popularity of Cicero in the 15th century supports the theory that the filler text has been used for centuries."
            },
            {
                key: "faq-4-4",
                open: false,
                title: "What are the benefits of a navigation system?",
                desc: "So how did the classical Latin become so incoherent? According to McClintock, a 15th century typesetter likely scrambled part of Cicero's De Finibus in order to provide placeholder text to mockup various fonts for a type specimen book. Aldus Corporation, which later merged with Adobe Systems, ushered lorem ipsum into the information age with its desktop publishing software Aldus PageMaker. The program came bundled with lorem ipsum dummy text for laying out page content, and other word processors like Microsoft Word followed suit."
            },
            {
                key: "faq-4-5",
                open: false,
                title: "Versioning",
                desc: "So when is it okay to use lorem ipsum? First, lorem ipsum works well for staging. It's like the props in a furniture store—filler text makes it look like someone is home. The same Wordpress template might eventually be home to a fitness blog, a photography website, or the online journal of a cupcake fanatic. Lorem ipsum helps them imagine what the lived-in website might look like."
            },
        ]
    }

    constructor() { }

    ngOnInit(): void { }

    selectCategory (category: string) {
        this.selectedCategory = category;
    }
}
