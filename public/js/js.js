document.addEventListener('alpine:init',()=>{
    Alpine.data('data',()=>({
        //General Info
        fullViewOption:false,
        optionId:0,
        options:[
            {
                optionId:1,
                optionName:'Supplier',
                isOpen:false
            },
            {
                optionId:2,
                optionName:'Rates',
                isOpen:false
            },
            {
                optionId:3,
                optionName:'Charges',
                isOpen:false
            },
            {
                optionId:4,
                optionName:'Assortment',
                isOpen:false
            },
            {
                optionId:5,
                optionName:'Stores',
                isOpen:false
            },
            {
                optionId:6,
                optionName:'Info',
                isOpen:false
            },
        ],

        //Tabs
        activeTab:'preview',

        handleOption(optionId){
            this.optionId = optionId
            this.options = this.options.map(o=>{
                if(o.optionId === optionId)
                {
                    return {...o, isOpen:!o.isOpen}
                }
                return o
            })
        },
    }))

    Alpine.store('global',{

         //Supplier
            searchStringSupplier:'',
            isLoading:false,
            supplier:
            {
                code:'',
                name:''
            },
            optionId:10,

            getAll(){
                axios.get('/getAll',
                {
                    params:
                    {
                        searchString:this.searchStringSupplier
                    }
                })
                .then((res)=>{
                    
                    if(res.data.supplier.length === 1 )
                    {
                        this.supplier.code = res.data.supplier[0].supplier
                        this.supplier.name = res.data.supplier[0].sup_name
                        //New Arrays in Stores
                        this.availableStores = res.data.stores

                        //new Arrays in BrandsWithConcessionRates
                        this.brandswithConcessionRates = res.data.brandswithConcessionRate

                        //new Arrays in Merchandise Assortment
                        console.log(res.data.subDept.filter((v,i,a)=>a.findIndex(v2=>(v2.group_no === v.group_no)) === i))
                        //Sanitize data
                        this.classCodeDescriptions = []
                        this.classCodes = res.data.subDept

                    }
                    else
                    {
                        
                        this.supplier = {code:'',name:''}
                        this.stores = []
                        this.brands = []
                        this.commissionType = ''
                        this.brandswithConcessionRate = []
                        this.brands = []
                        this.classCodeDescriptions = []
                    }
                    
                })
            },

            handlefired(){
                
                console.log(this.brandswithConcessionRates)
                console.log(this.commRates)
            },
        
        //Charges
            charges:
            {
                maps:
                {
                    chargeName:'Monthly Advertising and Promotional Support',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },
                muec:
                {
                    chargeName:'Monthly Utilities Expense Charge',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },
                mssc:
                {
                    chargeName:'Monthly Store Supplies Charge',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },
                nsos:
                {
                    chargeName:'New Store Opening Support',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },
                cd:
                {
                    chargeName:'Christmas Discount',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },
                mvpse:
                {
                    chargeName:'Monthly Vendor Portal Subscription Fee',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },
                mcimsf:
                {
                    chargeName:'Monthly Concession Inventory Management Subscription Fee',
                    chargeType:'',
                    percentage:'',
                    fixedValue:'',
                    startMonth:'',
                    endMonth:'',
                    postingCycle:''
                },    
            },
        
        //Assortment
            classCodes:[],
            classCodeDescriptions:[],

            //Group
            handleAddClassCodeDescriptions(){
                this.classCodeDescriptions
                .push(
                    {
                        group:
                        {
                            no:null,
                            name:null
                        },
                        productCycle:null,
                        timeline:null,
                        dept:
                        {
                            no:null,
                            name:null
                        },
                        class:
                        {
                            no:null,
                            name:null
                        },
                        subClass:[]
                    }
                )
            },

            filterGroup(searchedString){
                return this.classCodes.filter((v,i,a)=>a.findIndex(v2=>(v2.group_no === v.group_no)) === i)
                .filter((item)=>
                    item.group_no.toLowerCase().includes(searchedString.toLowerCase()) ||
                    item.group_name.toLowerCase().includes(searchedString.toLowerCase())
                )
                
            },

            handleRemoveDepartment(index){
                this.classCodeDescriptions.splice(index, 1)
            },

            handleChooseGroupOption(groupNo, groupName ,index){
                let classCode = this.classCodeDescriptions[index]
                if(classCode.group.no !== groupNo)
                {
                    classCode.group.no = groupNo
                    classCode.group.name = groupName
                    classCode.dept = {no:null,name:null}
                    classCode.class = {no:null,name:null}
                    classCode.subClass = []
                }
                else
                {
                    classCode.group.no = null
                    classCode.group.name = null
                    classCode.dept = {no:null,name:null}
                    classCode.class = {no:null,name:null}
                    classCode.subClass = []
                }
                
            },

            checkIfChoosenGroupOption(index,groupIndex, groupNo){
                
                if(this.classCodeDescriptions[index].group.no === groupNo)
                {
                    console.log(index,groupIndex,groupNo)
                    return true
                }

                return false
            },

            //Department
            filterDepartment(searchedString, index){
                return this.classCodes.filter((item)=> item.group_no === this.classCodeDescriptions[index].group.no)
                .filter((v,i,a)=>a.findIndex(v2=>(v2.group_no === v.group_no && v2.dept === v.dept )) === i)
                .filter((item)=>
                    item.dept.toLowerCase().includes(searchedString.toLowerCase()) ||
                    item.dept_name.toLowerCase().includes(searchedString.toLowerCase())
                )
            },

            handleEmptySubDepartment(index){
                this.classCodeDescriptions = this.classCodeDescriptions.map((item,ind)=>{
                    if(ind === index)
                    {
                        return { ...item, dept:{no:'',name:''},class:{no:'',name:''},subClass:[]}
                    }
                    return item
                })
            },

            //Class
            filterClass(searchedString,index){
                let toArray = 
                    this.classCodes.filter((item)=> 
                    item.group_no === this.classCodeDescriptions[index].group.no && 
                    item.dept === this.classCodeDescriptions[index].dept.no)
                .filter((v,i,a)=>a.findIndex(v2=>(v2.group_no === v.group_no && v2.dept === v.dept &&v2.class === v.class)) === i)
                .filter((item)=>
                    item.class.toLowerCase().includes(searchedString.toLowerCase()) ||
                    item.class_name.toLowerCase().includes(searchedString.toLowerCase())
                )
                return toArray
            },

            handleEmptyClass(index){
                this.classCodeDescriptions = this.classCodeDescriptions.map((item,ind)=>{
                    if(ind === index)
                    {
                        return { ...item, class:{no:'',name:''},subClass:[]}
                    }
                    return item
                })
            },

            //Sub Class
            filterSubClass(searchString, index){
                let toArray = 
                this.classCodes.filter((item)=> 
                item.group_no === this.classCodeDescriptions[index].group.no && 
                item.dept === this.classCodeDescriptions[index].dept.no &&
                item.class === this.classCodeDescriptions[index].class.no)
                .filter((v,i,a)=>a.findIndex(v2=>( v2.subclass === v.subclass && v2.sub_name === v.sub_name )) === i)
                .filter((item)=>
                    item.subclass.toLowerCase().includes(searchString.toLowerCase()) ||
                    item.sub_name.toLowerCase().includes(searchString.toLowerCase())
                )
                return toArray
            },
        

        //CommRates
            commissionType:'',
            searchStringCommratesOptions:'',
            commRates:[],
            brandswithConcessionRates:[],
            commissionRates:[],



            filterCommRates(searchString){
                let newArr =  this.brandswithConcessionRates.filter((v,i,a)=>a.findIndex(v2=>(v2.concession_rate === v.concession_rate)) === i)
                .filter(item=>
                    String( 100 - parseInt(item.concession_rate)).toLowerCase().includes(searchString.toLowerCase())
                )
                return newArr
            },

            handleChooseCommRateOption(commRate){
            
                console.log(commRate)
                if(this.commissionRates.map((item)=>{return item.concession_rate}).includes(commRate))
                {
                    this.commissionRates = this.commissionRates.filter((item)=> item.concession_rate !== commRate)
                }
                else
                {   
                    this.commissionRates.push(
                        {
                            concession_rate:commRate,
                            concession_desc:null,
                            brands:[]
                        }
                    )
                }
                
            },

            filterBrands(commissionRate){
                let filteredByCommission =  this.brandswithConcessionRates.filter(item =>
                    item.concession_rate === commissionRate
                )
                return filteredByCommission.filter(item=>
                    item.uda_value.toLowerCase().includes(this.searchStringBrandsOptions.toLowerCase()) || 
                    item.uda_value_desc.toLowerCase().includes(this.searchStringBrandsOptions.toLowerCase())   
                )
            },

            filterBrandsChoosen(commisionRate){
                return this.brandswithConcessionRates.filter(item=> item.isPicked && item.concession_rate === commisionRate )
            },

            uniqueBrand(){
                
                let brands =  this.brandswithConcessionRates.filter((item)=>{
                    if(item.isPicked)
                    {
                        return {brand: item.uda_value_desc}
                    }
                })
                brands = brands.filter((v,i,a)=>a.findIndex(v2=>(v2.uda_value === v.uda_value)) === i)
                return brands
            },

        //Store
        availableStores:[],
        stores:[],
        filterStore(){
            return this.stores
            .filter(item =>
                item.store_name.toLowerCase().includes(this.searchStringStoreOptions.toLowerCase()) || 
                item.loc.toLowerCase().includes(this.searchStringStoreOptions.toLowerCase())
            )
        },

        handleChooseStoreOption(storeCode){

            this.stores = this.stores.map((item)=>{
                if( item.loc === storeCode && item.isPicked === false)
                {
                    return {...item, isPicked:true}
                }
                if (item.loc === storeCode && item.isPicked === true)
                {
                    return {...item, isPicked:false}
                }
                return item
            })
        },

        //All 
            inputs:{
                representativeName:'',
                representativePosition:'',
                address:'',
                startDate:'',
                endDate:''
            }
            
    })

})
                                                                                    