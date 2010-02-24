/*
 *This file is part of SparkWeb.
 *
 *SparkWeb is free software: you can redistribute it and/or modify
 *it under the terms of the GNU Lesser General Public License as published by
 *the Free Software Foundation, either version 3 of the License, or
 *(at your option) any later version.
 *
 *SparkWeb is distributed in the hope that it will be useful,
 *but WITHOUT ANY WARRANTY; without even the implied warranty of
 *MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *GNU Lesser General Public License for more details.
 *
 *You should have received a copy of the GNU Lesser General Public License
 *along with SparkWeb.  If not, see <http://www.gnu.org/licenses/>.
 */

package com.jivesoftware.spark.managers
{
	import commun.Constantes;
	
	import flash.events.EventDispatcher;
	
	import mx.collections.ArrayCollection;
	
	import org.igniterealtime.xiff.data.*;
	import org.igniterealtime.xiff.data.im.Contact;
	import org.igniterealtime.xiff.data.im.RosterItemVO;
	
	public class PresenceManager extends EventDispatcher {
		/*[Embed(source="/assets/images/im_free_chat.png")]
		private static const freeToChat:Class;
		
		[Embed(source="/assets/images/im_available.png")]
		public static const imAvailable:Class;
		
		[Embed(source="/assets/images/im_away.png")]
		private static const imAway:Class;
		
		[Embed(source="/assets/images/on-phone.png")]
		private static const onPhone:Class;
		
		[Embed(source="/assets/images/airplane.png")]
		private static const onTheRoad:Class;
		
		[Embed(source="/assets/images/im_away.png")]
		private static const imExtendedAway:Class;
		
		[Embed(source="/assets/images/im_dnd.png")]
		private static const imDND:Class;
		
		[Embed(source="/assets/images/im_unavailable.png")]
		private static const unavailable:Class;
		
		[Embed(source="/assets/images/pending.png")]
		private static const pending:Class;*/
		
		
        [Embed(source="assets/images/en_ligne.png")]
        public static const EnLigne:Class;

        
        [Embed(source="assets/images/occupe.png")]
        public static const Occupe:Class;

        
        [Embed(source="assets/images/absent.png")]
        public static const Absent:Class;
		
		
        [Embed(source="assets/images/de_retour.png")]
        public static const Retour:Class;
        
        
        [Embed(source="assets/images/hors_ligne.png")]
        public static const HorsLigne:Class;

		public static const presences:ArrayCollection = new ArrayCollection([
		{ label: Constantes.ENLIGNE, shortName: Constantes.ENLIGNE, icon: EnLigne, presence:null},
		{ label: Presence.SHOW_AWAY, shortName: Presence.SHOW_AWAY, icon: Absent, presence:Presence.SHOW_AWAY},
		{ label: Presence.SHOW_XA, shortName: Presence.SHOW_XA, icon: Retour, presence:Presence.SHOW_XA},
		{ label: Constantes.HORSLIGNE, shortName: Constantes.HORSLIGNE, icon: HorsLigne, presence:Constantes.HORSLIGNE},
		{ label: Presence.SHOW_DND, shortName: Constantes.OCCUPE, icon: Occupe, presence:Presence.SHOW_DND}
		]);
		
		/**
		 * Returns the icon representative of presence.
		 * TODO: Should we consider nuking this one?  It's kind of a hack.  ChatRoom uses it though.
		 * @param the string representation of presence.
		 * @return the icon representing the presence.
		 */
		public function getIconFromPresence(presence:String):Class 
		{
			if (presence == "Pending")
				return Absent;
			
			for each(var p:Object in presences)
			{
				if(p.presence == presence)
				{	
					return p.icon;
				}
			}
			
			return HorsLigne;
		}
		
		public function changePresence(newShow:String, newStatus:String, newPriority:Number = -1000):void
		{
			if(newPriority == -1000)
			{
				switch(newShow)
				{
					case Presence.SHOW_DND:
						newPriority = -5;
					case Presence.SHOW_AWAY:
						newPriority = -1;
						break;
					case Presence.SHOW_CHAT:
						newPriority = 5;
						break;
					case Presence.SHOW_XA:
						newPriority = -9;
						break;
					default:
						newPriority = 0;
						break;	
				}
			}
			var presence:Presence = new Presence();
			presence.show = newShow;
			presence.priority = newPriority;
			presence.status = newStatus;
			SparkManager.connectionManager.connection.send(presence);
			//updateRosterItemPresence(SparkManager.me, presence);
			//changePresence(newShow, newStatus, newPriority);
		}
		
		/**
		 * Returns the icon representation of presence, based off the entire roster item.
		 * @param the RosterItemVO object.
		 * @param dummy presence string that will trigger this to update
		 * @param dummy online status that will trigger this to update
		 * @param dummy pending status that will trigger this to update
		 * @return the icon representing the presence.
		 */
		 public function getIconFromRosterItem(item:*, presence:String=null, onlineStatus:Boolean=false, pendingStatus:Boolean=false):Class
		 {
		 	//TODO: rework BuddyRenderer and MUCOccupantRenderer to allow for this to be statically typed
		 	if(!item is Contact)
		 		return EnLigne;
		 	
		 	if (item is RosterItemVO && (item as RosterItemVO).pending) {
		 		return Absent;
		 	}
		 	
		 	if(item is RosterItemVO && !(item as RosterItemVO).online)
				return HorsLigne;
		 				
			for each(var p:Object in presences)
			{
				if(p.presence == item.show)
					return p.icon;
			}
			
			return EnLigne;
		 }
	}
}
