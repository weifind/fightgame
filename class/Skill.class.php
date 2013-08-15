<?php
//技能
class Skill
{      
    CONST SKILL_GROUP_WLGJ = 1;//物理攻击
    CONST SKILL_GROUP_FSGJ = 2;//法术攻击
    CONST SKILL_GROUP_BDJN = 3;//被动技能
    CONST SKILL_GROUP_FYJN = 4;//防御技能

    CONST DEFAULT_SKILL_POINT   = 3;//默认用户拥有的技能点

    /** 
     * 技能array(技能缩写code,所属分组，消耗魔法值)
     *
     * */
    public static $skill_info    = array(
        ConfigDefine::SKILL_ZJ  => array('zj', self::SKILL_GROUP_WLGJ),
        ConfigDefine::SKILL_LJ  => array('lj', self::SKILL_GROUP_WLGJ),
        ConfigDefine::SKILL_LXYZ    => array('lxyz', self::SKILL_GROUP_WLGJ, 50),
        ConfigDefine::SKILL_SWZH    => array('swzh', self::SKILL_GROUP_FSGJ, 70),
        ConfigDefine::SKILL_HFHY    => array('hfhy', self::SKILL_GROUP_FSGJ, 30),
        ConfigDefine::SKILL_WLJ => array('wlj', self::SKILL_GROUP_FSGJ, 20),
        ConfigDefine::SKILL_WFX => array('wfx', self::SKILL_GROUP_BDJN),
        ConfigDefine::SKILL_FFX => array('ffx', self::SKILL_GROUP_BDJN),
        ConfigDefine::SKILL_GX  => array('gx', self::SKILL_GROUP_BDJN),
        ConfigDefine::SKILL_FX  => array('fx', self::SKILL_GROUP_BDJN),
        ConfigDefine::SKILL_DZ  => array('dz', self::SKILL_GROUP_BDJN),
        ConfigDefine::SKILL_FY  => array('fy', self::SKILL_GROUP_FYJN),
        ConfigDefine::SKILL_FJ  => array('fj', self::SKILL_GROUP_FYJN),
        ConfigDefine::SKILL_FD  => array('fd', self::SKILL_GROUP_FYJN)
    );

    /** 技能对应数据库map **/
    public static $skill_map    = array(
        'zj'    => ConfigDefine::SKILL_ZJ,
        'lj'    => ConfigDefine::SKILL_LJ,
        'lxyz'  => ConfigDefine::SKILL_LXYZ,
        'swzh'  => ConfigDefine::SKILL_SWZH,
        'hfhy'  => ConfigDefine::SKILL_HFHY,
        'wlj'   => ConfigDefine::SKILL_WLJ,
        'wfx'   => ConfigDefine::SKILL_WFX,
        'ffx'   => ConfigDefine::SKILL_FFX,
        'gx'    => ConfigDefine::SKILL_GX,
        'fx'    => ConfigDefine::SKILL_FX,
        'dz'    => ConfigDefine::SKILL_DZ,
        'fy'    => ConfigDefine::SKILL_FY,
        'fj'    => ConfigDefine::SKILL_FJ,
        'fd'    => ConfigDefine::SKILL_FD,
    );

    /** 主动技能属性加成 */
    private static $_skill_attributes    = array(
        ConfigDefine::SKILL_ZJ  => array(
            ConfigDefine::USER_ATTRIBUTE_HIT    => 12
            ),
        ConfigDefine::SKILL_LJ  => array(
            ConfigDefine::USER_ATTRIBUTE_HURT   => 3
            ),
        ConfigDefine::SKILL_SWZH  => array(
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC    => 4
            ),
        ConfigDefine::SKILL_HFHY  => array(
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC    => 3
            ),
        ConfigDefine::SKILL_WLJ  => array(
            ConfigDefine::USER_ATTRIBUTE_PSYCHIC    => 1
            )
        );

    //技能组及对应技能
    public static function skillGroupList()
    {
        $skillGroupList = array(
            self::SKILL_GROUP_WLGJ => array(ConfigDefine::SKILL_ZJ, ConfigDefine::SKILL_LSYZ,),
            self::SKILL_GROUP_FSGJ => array(ConfigDefine::SKILL_SWZH, ConfigDefine::SKILL_HFHY, ConfigDefine::SKILL_WLJ,),
            self::SKILL_GROUP_BDJN => array(ConfigDefine::SKILL_WFX, ConfigDefine::SKILL_FFX, ConfigDefine::SKILL_GX, ConfigDefine::SKILL_FX, ConfigDefine::SEILL_DZ,),
            self::SKILL_GROUP_FYJN => array(ConfigDefine::SKILL_FY, ConfigDefine::SKILL_FJ, ConfigDefine::SKILL_FD),
        );
    }
    //获取技能分组
    public static function getSkillGroupBySkillCode($skill_code){
        return self::$skill_info[$skill_code][1];
    }
    //技能分组名称
    private static function _skillGroupNameList()
    {
        $skillGroupNameList = array(
            self::SKILL_GROUP_WLGJ => '物理攻击',
            self::SKILL_GROUP_FSGJ => '法术攻击',
            self::SKILL_GROUP_BDJN => '被动技能',
            self::SKILL_GROUP_FYJN => '防御技能',
        );
        return $skillGroupNameList;
    }

    //用户技能等级上限
    public static function skillLevelLimit($userLevel = 0)
    {
        return $userLevel + 10; 
    }
    //技能释放概率，基本释放概率和最高释放概率
    public static function skillUseProbability()
    {
        //canUserSkillNum => array(baseUseProbability => array(gj => 0.1, fy => 0.1), maxUseProbability => array(gj => 0.1 , fy => 0.1))
        $configList = array(
            1 => array(
                'baseUseProbability' => array('gj' => 0.25, 'fy' => 0.2),
                'maxUseProbability'  => array('gj' => 0.7, 'fy' => 0.6),
            ),
            2 => array(
                'baseUseProbability' => array('gj' => 0.3, 'fy' => 0.25),
                'maxUseProbability'  => array('gj' => 0.75, 'fy' => 0.65),
            ),
            3 => array(
                'baseUseProbability' => array('gj' => 0.35, 'fy' => 0.3),
                'maxUseProbability'  => array('gj' => 0.8, 'fy' => 0.7),
            ),
            4 => array(
                'baseUseProbability' => array('gj' => 0.4, 'fy' => 0.35),
                'maxUseProbability'  => array('gj' => 0.85, 'fy' => 0.75),
            ),
            5 => array(
                'baseUseProbability' => array('gj' => 0.45, 'fy' => 0.4),
                'maxUseProbability'  => array('gj' => 0.9, 'fy' => 0.8),
            ),
        );
    }

    /**
     * @desc 获取额外加成后的角色属性
     * @param $attributes 角色成长属性
     *
     */
    public static function getRoleAttributesWithSkill($attributes, $skills = NULL){
        if(empty($skills)){
            return $attributes;
        }

        foreach($skills as $skill => $level){
            if($level == 0){
                continue;
            }
            //主动技能
            if(self::$skill_info[$skill][1] == self::SKILL_GROUP_WLGJ  || self::$skill_info[$skill][1] == self::SKILL_GROUP_FSGJ){
                $skill_attr = self::$_skill_attributes[$skill];
                foreach($skill_attr as $attr => $value){
                    $attributes[$attr]  += $value * $level;
                }
            }
        }
        //被动技能需放最后加成
        foreach($skills as $skill => $level){
                $skill      = self::$skill_info[$skill][0];
                $attrAdd    = call_user_func(array('Skill_Config', $skill.'SkillFormula'), $attributes);
                foreach($attrAdd as $attr => $value){
                    //第一个属性
                    $attributes[$attr]  += $value * $level;
                }
            }
        }

        return $attributes;
    }

    /**
     * @desc 使用技能(主动技能)
     *
     *                     skill_code, 技能code或缩写
     * @param data =    array(  当前攻击者属性
     *                     user_level,
     *                     skills(
     *                          'skill_code'    => level,
     *                      ),
     *                      attributes(
     *                      ConfigDefine::
     *                          14个成长属性+装备属性
     *                      )
     * @param op_data 被攻击者属性，格式与攻击者属性一致
     */
    public static function useSkill($skill_code, $data, $op_data){
        //成长属性
        //$attributes = User_Attributes::getInfoByRaceAndLevel($role_info['race_id'], $role_info['user_level'], TRUE); 
        //技能加成属性
        $attributes = self::getRoleAttributesWithSkill($data['attributes'], $data['skills']);
        //构造额外需要参数
        $attributes['role_level']   = $data['user_level'];
        $attributes['skill_level']  = $data['skills'][$skill_code];
        if(is_numeric($skill_code)){
            $skill      = self::$skill_info[$skill_code][0];
        } else {
            $skill      = $skill_code;
        }
        //怪物防御 基本+技能 TODO
        $op_atrributes  = self::getRoleAttributesWithSkill($op_data['attributes'], $data['skills']);

        return call_user_func(array('Skill_Config', $skill.'SkillFormula'), $attributes);
    }

    /**
     * @desc 获取当前技能消耗魔法值
     */
    public static function getNeedMagicBySkillCode($skill_code){
        if(isset(self::$skill_info[$skill_code][2])){
            return self::$skill_info[$skill_code][2];
        }
        return 0;
    }

}
